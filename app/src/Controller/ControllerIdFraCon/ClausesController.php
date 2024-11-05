<?php

namespace App\Controller\ControllerIdFraCon;

use App\Entity\EntityIdFraCon\Clauses;
use App\Form\FormIdFraCon\ClausesType;
use App\Repository\RepositoryIdFraCon\ClausesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/clauses')]
class ClausesController extends AbstractController
{
  #[Route('/', name: 'app_clauses_index', methods: ['GET'])]
  public function index(ClausesRepository $clausesRepository): Response
  {
    return $this->render('idfracon/clauses/index.html.twig', [
      'clauses' => $clausesRepository->findAll(),
    ]);
  }

  #[Route('/new', name: 'app_clauses_new', methods: ['GET', 'POST'])]
  public function new(Request $request, EntityManagerInterface $entityManager): Response
  {
    $clause = new Clauses();
    $form = $this->createForm(ClausesType::class, $clause);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $entityManager->persist($clause);
      $entityManager->flush();

      return $this->redirectToRoute('app_clauses_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('idfracon/clauses/new.html.twig', [
      'clause' => $clause,
      'form' => $form,
    ]);
  }

  #[Route('/{id}', name: 'app_clauses_show', methods: ['GET'])]
  public function show(Clauses $clause): Response
  {
    return $this->render('idfracon/clauses/show.html.twig', [
      'clause' => $clause,
    ]);
  }

  #[Route('/{id}/edit', name: 'app_clauses_edit', methods: ['GET', 'POST'])]
  public function edit(Request $request, Clauses $clause, EntityManagerInterface $entityManager): Response
  {
    $form = $this->createForm(ClausesType::class, $clause);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $entityManager->flush();

      return $this->redirectToRoute('app_clauses_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('idfracon/clauses/edit.html.twig', [
      'clause' => $clause,
      'form' => $form,
    ]);
  }

  #[Route('/{id}', name: 'app_clauses_delete', methods: ['POST'])]
  public function delete(Request $request, Clauses $clause, EntityManagerInterface $entityManager): Response
  {
    if ($this->isCsrfTokenValid('delete' . $clause->getId(), $request->getPayload()->getString('_token'))) {
      $entityManager->remove($clause);
      $entityManager->flush();
    }

    return $this->redirectToRoute('app_clauses_index', [], Response::HTTP_SEE_OTHER);
  }
}
