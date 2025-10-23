<?php

namespace App\Controller\ControllerSCPI;

use App\Entity\EntitySCPI\Actu;
use App\Form\FormMC\ActuType;
use App\Repository\RepositorySCPI\ActuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ActuController extends AbstractController
{
  #[Route("scpi/actu/", name: "actu_index", methods: ["GET"])]
  public function index(ActuRepository $actuRepository): Response
  {
    return $this->render('scpi/actu/index.html.twig', [
      'actus' => $actuRepository->findAll(),
    ]);
  }

  #[Route("scpi/actu/new", name: "actu_new", methods: ["GET", "POST"])]
  public function new(Request $request, EntityManagerInterface $entityManager): Response
  {
    $actu = new Actu();
    $form = $this->createForm(ActuType::class, $actu);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $entityManager->persist($actu);
      $entityManager->flush();

      return $this->redirectToRoute('actu_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('scpi/actu/new.html.twig', [
      'actu' => $actu,
      'form' => $form,
    ]);
  }

  #[Route("scpi/actu/{slug}", name: "actu_show", methods: ["GET"])]
  public function show(#[MapEntity(mapping: ['slug' => 'slug'])] Actu $actu): Response
  {
    return $this->render('scpi/actu/show.html.twig', [
      'actu' => $actu,
    ]);
  }

  #[Route("scpi/actu/{id}/edit", name: "actu_edit", methods: ["GET", "POST"])]
  public function edit(Request $request, Actu $actu, EntityManagerInterface $entityManager): Response
  {
    $form = $this->createForm(ActuType::class, $actu);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $entityManager->flush();

      return $this->redirectToRoute('actu_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('scpi/actu/edit.html.twig', [
      'actu' => $actu,
      'form' => $form,
    ]);
  }

  #[Route("scpi/actu/{id}", name: "actu_delete", methods: ["POST"])]
  public function delete(Request $request, Actu $actu, EntityManagerInterface $entityManager): Response
  {
    if ($this->isCsrfTokenValid('delete' . $actu->getId(), $request->request->get('_token'))) {
      $entityManager->remove($actu);
      $entityManager->flush();
    }

    return $this->redirectToRoute('actu_index', [], Response::HTTP_SEE_OTHER);
  }
}
