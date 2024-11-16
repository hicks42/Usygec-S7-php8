<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserEditType;
use App\Form\FormBam\CsvType;
use App\Service\CompanyCsvManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\SwitchUserToken;

class UserController extends AbstractController
{

  private $security;

  public function __construct(Security $security)
  {
    $this->security = $security;
  }

  #[Route("/usygec/settings", name: "usygec_settings")]
  // #[IsGranted('ROLE_ADMIN')]
  public function editUsygecUser(Request $request, CompanyCsvManager $companyCsvImporter): Response
  {
    $token = $this->security->getToken();

    if ($token instanceof SwitchUserToken) {
      $user = $token->getOriginalToken()->getUser();
    } else {
      $user = $this->security->getUser();
    }

    $formcsv = $this->createForm(CsvType::class);
    $formcsv->handleRequest($request);

    if ($formcsv->isSubmitted() && $formcsv->isValid()) {

      /** @var UploadedFile */
      $csvFile = $formcsv->get('csvFile')->getData();
      if ($csvFile) {

        $companyCsvImporter->importCompaniesFromCsv($csvFile, $user);

        $this->addFlash('success', 'Sociétés Enregistrée');
        return $this->redirectToRoute('app_companies', ["user" => $user], Response::HTTP_SEE_OTHER);
      }
      $this->addFlash('error', 'Fichier non conforme');
      return $this->redirectToRoute('ezreview_hp', ["user" => $user], Response::HTTP_SEE_OTHER);
    }

    return $this->render('main/usygec_settings.html.twig', [
      'formcsv' => $formcsv->createView(),
      'user' => $user,
    ]);
  }

  #[Route('/user/edit/{id}', name: 'user_edit')]
  #[IsGranted('ROLE_ADMIN')]
  public function edit(User $user, Request $request, EntityManagerInterface $em): Response
  {
    $form = $this->createForm(UserEditType::class, $user);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $user->setRoles($form->get('roles')->getData());
      $plainPassword = $form->get('plainPassword')->getData();
      if ($plainPassword) {
        $hashedPassword = password_hash($plainPassword, PASSWORD_BCRYPT);
        $user->setPassword($hashedPassword);
      }

      $em->persist($user);
      $em->flush();

      $this->addFlash('success', 'Utilisateur mis à jour avec succès.');

      return $this->redirectToRoute('accounts_index');
    }

    return $this->render('user_edit.html.twig', [
      'form' => $form->createView(),
      'user' => $user,
    ]);
  }
}
