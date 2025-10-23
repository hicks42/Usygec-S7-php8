<?php

namespace App\Controller\ControllerSCPI;

use App\Entity\EntitySCPI\Actu;
use App\Entity\EntitySCPI\Produit;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomepageController extends AbstractController
{
  #[Route("/scpi/home", name: "scpi_hp")]
  public function index(EntityManagerInterface $em): Response
  {
    $promos = $em->getRepository(Produit::class)->findBy(['isPromo' => true], ['id' => 'DESC']);
    $actus = $em->getRepository(Actu::class)->findBy(['isOnline' => true], ['id' => 'DESC']);

    return $this->render(
      'scpi/scpi_hp.html.twig',
      compact('promos', 'actus'),
    );
  }
}
