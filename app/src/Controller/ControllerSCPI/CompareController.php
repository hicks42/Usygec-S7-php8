<?php

namespace App\Controller\ControllerSCPI;

use App\Classe\ClasseSCPI\Compare;
use App\Entity\EntitySCPI\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompareController extends AbstractController
{
  private $em;

  public function __construct(EntityManagerInterface $em)
  {
    $this->em = $em;
  }


  #[Route("scpi/comparator/{str}", name: "compare_array", methods: ["GET"])]
  public function view($str)
  {
    // gathering all the fields direct and associated
    $directfields = $this->em->getClassMetadata(Produit::class)->getFieldNames();
    array_shift($directfields);
    array_splice($directfields, -2);
    $temparray = array_diff($directfields, ["slug", "imageName", "isPromo"]);
    $assocfields = $this->em->getClassMetadata(Produit::class)->getAssociationNames();
    $allfields = array_merge($temparray, $assocfields);

    foreach ($allfields as $field) {
      $fieldnames[] = $this->snakeToCamel($field);
    }
    // moving associated fields
    $oldCatKey = array_search('categorie', $allfields);
    $newCatKey = array_search('soc_gest', $allfields) + 1;
    $this->moveElement($fieldnames, $oldCatKey, $newCatKey);

    $oldPerfdKey = array_search('performances', $allfields);
    $newPerfKey = array_search('nb_assoc', $allfields) + 1;
    $this->moveElement($fieldnames, $oldPerfdKey, $newPerfKey);

    $oldPerfdKey = array_search('repartSectors', $allfields);
    $newPerfKey = array_search('infoTrim', $allfields) + 2;
    $this->moveElement($fieldnames, $oldPerfdKey, $newPerfKey);

    $oldPerfdKey = array_search('repartGeos', $allfields);
    $newPerfKey = array_search('lifeAssetTrim', $allfields) + 2;
    $this->moveElement($fieldnames, $oldPerfdKey, $newPerfKey);


    if (!is_null($str)) {
      $compareDetail = [];
      // les compare de la session sont captés par l'ID et stocké ds compareDetail[]
      $produitsIds = explode(',', $str);
      foreach ($produitsIds as $id) {
        $compareDetail[] = [
          'produit' => $this->em->getRepository(Produit::class)->findOneById($id),
        ];
        $nbr = count($compareDetail);
        if ($nbr == 1) {
          $col1 = 4;
          $lastcols = 8;
        } elseif ($nbr == 2) {
          $col1 = 4;
          $lastcols = 4;
        } else {
          $col1 = 3;
          $lastcols = 3;
        };
      }
    } else {
      $compareDetail = null;
    }

    return $this->render('scpi/produit/compare.html.twig', [
      'col1' => $col1,
      'lastcols' => $lastcols,
      'compare' => $compareDetail,
      'fieldnames' => $fieldnames,
    ]);
  }

  #[Route("scpi/comparateur", name: "compare", methods: ["GET"])]
  public function index(Compare $compare)
  {

    if (!is_null($compare->get())) {

      $compareDetail = [];
      // les compare de la session sont captés par l'ID et stocké ds compareDetail[]
      foreach ($compare->get() as $id) {
        $compareDetail[] = [
          'produit' => $this->em->getRepository(Produit::class)->findOneById($id),
        ];
      }
    } else {
      $compareDetail = null;
    }

    return $this->render('scpi/produit/compare.html.twig', [
      'compare' => $compareDetail
    ]);
  }

  #[Route("scpi/compare/add/{id}", name: "add_to_compare")]
  public function add(Compare $compare, $id)
  {
    $compare->add($id);

    return $this->redirectToRoute('compare');
  }

  #[Route("scpi/compare/erase", name: "erase_compare")]
  public function remove(Compare $compare)
  {
    $compare->remove();
    return $this->redirectToRoute('produits');
  }


  // les fonctions pour formate et bouger les fields
  private function moveElement(&$array, $a, $b)
  {
    $out = array_splice($array, $a, 1);
    array_splice($array, $b, 0, $out);
  }

  function camel_to_snake($input)
  {
    return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
  }

  function snakeToCamel($input)
  {
    return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $input))));
  }
}
