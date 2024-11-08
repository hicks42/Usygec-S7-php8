<?php

namespace App\Controller;

use App\Entity\User;
use League\Csv\Reader;
use App\Form\EmailCsvType;
use App\Form\ChangeMailFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountController extends AbstractController
{
  private $mailService;
  private $security;

  public function __construct(Security $security)
  {
    $this->security = $security;
  }

  #[Route("/ezreview/accounts", name: "accounts_index")]
  #[IsGranted('ROLE_ADMIN')]
  public function index(UserRepository $userRepo): Response
  {
    $users = $userRepo->findBy([], ['email' => 'DESC']);

    return $this->render('ezreview/account/account_index.html.twig', compact('users'));
  }

  #[Route("/ezreview/account/{id<[0-9]+>}/edit", name: "account_edit", methods: ["GET", "POST"])]
  #[IsGranted('ROLE_ADMIN')]
  public function edit(Request $request, EntityManagerInterface $em, User $user): Response
  {
    $form = $this->createForm(ChangeMailFormType::class, $user, [
      'method' => 'POST',
    ]);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $em->flush();

      $this->addFlash('success', 'Votre compte a été modifié !');

      return $this->redirectToRoute('accounts_index');
    }

    return $this->render('ezreview/account/account_edit.html.twig', [
      'form' => $form->createView(),
      'user' => $user
    ]);
  }

  #[Route("/account/{id<\d+>}/delete", name: "account_delete", methods: ["POST"])]
  #[IsGranted('ROLE_ADMIN')]
  public function delete(Request $request, EntityManagerInterface $em, User $user): Response
  {
    if ($this->isCsrfTokenValid('user_deletion_' . $user->getId(), $request->request->get('csrf_token'))) {
      $em->remove($user);
      $em->flush();

      $this->addFlash('info', 'Utilisateur supprimé !!!');
    }

    return $this->redirectToRoute('accounts_index');
  }
}
