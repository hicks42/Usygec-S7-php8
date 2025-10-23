<?php

namespace App\Controller\ControllerSCPI;

use App\Classe\ClasseSCPI\Search;
use App\Entity\EntitySCPI\Produit;
use App\Form\FormSCPI\SearchType;
use App\Repository\RepositorySCPI\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{
  private $em;

  public function __construct(EntityManagerInterface $em)
  {
    $this->em = $em;
  }

  #[Route("scpi/produits", name: "produits")]
  public function index(Request $request): Response
  {
    $produits = $this->em->getRepository(Produit::class)->findAll();

    $search = new Search();
    $form = $this->createForm(SearchType::class, $search);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $produits = $this->em->getRepository(Produit::class)->findWithSearch($search);
    }

    return $this->render('scpi/produit/produits.html.twig', [
      'produits' => $produits,
      'form' => $form->createView()
    ]);
  }

  #[Route("scpi/produit/{slug}", name: "produit_show")]
  public function show(ProduitRepository $repo, $slug): Response
  {
    $produit = $repo->findOneBySlug($slug);
    return $this->render(
      'scpi/produit/produit_show.html.twig',
      compact('produit'),
    );
  }
}
