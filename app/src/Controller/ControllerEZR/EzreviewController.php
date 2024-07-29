<?php

namespace App\Controller\ControllerEZR;

use App\Form\UserType;
use League\Csv\Reader;
use App\Service\MailJetService;
use App\Service\SendMailService;
use App\Form\FormEZR\TargetType;
use App\Form\FormEZR\EmailCsvType;
use App\Form\FormEZR\BadReviewType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Repository\RepositoryEZR\StructureRepository;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EzreviewController extends AbstractController
{
  private $security;
  private $mailService;
  private $structureRepo;
  private $user;

  public function __construct(MailJetService $mailService, StructureRepository $structureRepo, Security $security)
  {
    $this->security = $security;
    $this->mailService = $mailService;
    $this->structureRepo = $structureRepo;
    $this->user = $this->security->getUser();
  }

  #[Route("/ezreview/", name: "ezreview_hp")]
  #[IsGranted('ROLE_USER')]
  public function show(Request $request, SluggerInterface $slugger): Response
  {
    $form = $this->createForm(EmailCsvType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      /** @var UploadedFile $csvFile */

      $csvFile = $form['csvFile']->getData();
      $structureId = $form['structureId']->getData();

      if ($csvFile) {
        $baseUrl = $request->getSchemeAndHttpHost();

        $newFilename = $this->getNewFileName($csvFile, $slugger);

        $targets = $this->getEmailsArray($newFilename);
        foreach ($targets as $target) {
          $this->mailService->send($baseUrl, $target, $structureId);
        }
        $this->deleteFile($newFilename);
      }
      $this->addFlash('success', 'Ficier csv traité !');
      return $this->redirectToRoute('ezreview_hp');
    }
    return $this->render('ezreview/ezreview_hp.html.twig', [
      'user' => $this->user,
      'form' => $form->createView(),
    ]);
  }

  #[Route("/ezreview/settings", name: "ezreview_settings")]
  #[IsGranted('ROLE_USER')]
  public function editEzreviewUser(Request $request, EntityManagerInterface $em): Response
  {

    $form = $this->createForm(UserType::class, $this->user, [
      'method' => 'POST',
    ]);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $structures = $this->user->getStructures();

      foreach ($structures as $key => $structure) {

        $structure->setUser($this->user);
        $structures->set($key, $structure);
      }

      $em->flush();

      $this->addFlash('success', 'Modification enregistrée.');

      return $this->redirectToRoute('ezreview_settings');
    }

    return $this->render('ezreview/ezreview_settings.html.twig', [
      'form' => $form->createView(),
      'user' => $this->user
    ]);
  }

  #[Route("/ezreview/{id<\d+>}/survey ", name: "survey")]
  #[IsGranted('ROLE_USER')]
  public function survey(Request $request, $id): Response
  {
    $structure = $this->structureRepo->findOneById($id);
    $badRevUrl = $structure->getBadRevUrl();
    $GooglUrl = "https://search.google.com/local/writereview?placeid=" . $structure->getPid();
    $image = $structure->getImageName();

    return $this->render('ezreview/ezreview_survey.html.twig', [
      'structure' => $structure,
      'badRevUrl' => $badRevUrl,
      'GooglUrl' => $GooglUrl,
      'image' => $image,
    ]);
  }

  #[Route("/ezreview/{id<\d+>}/enquete/", name: "enquete")]
  #[IsGranted('ROLE_USER')]
  public function sendOneEmail(Request $request, MessageBusInterface $bus, $id): Response
  {
    $baseUrl = $request->getSchemeAndHttpHost();
    $form = $this->createForm(TargetType::class);
    $target = $form->handleRequest($request)->get('email')->getData();

    if ($form->isSubmitted() && $form->isValid()) {

      $this->mailService->send($baseUrl, $target, $id);

      $this->addFlash('success', 'Le mail a bien été envoyé !');
      return $this->redirectToRoute('enquete', ['id' => $id]);
    }
    return $this->render('ezreview/target_form.html.twig', [
      'form' => $form->createView(),
    ]);
  }

  #[Route("/badreview/{structureId}", name: "badreview")]
  public function badreview(Request $request, SendMailService $sendMailService, $structureId): Response
  {
    $form = $this->createForm(BadReviewType::class);
    $badreview = $form->handleRequest($request);
    $structure = $this->structureRepo->findOneById($structureId);
    $userMail = $structure->getUser()->getEmail();
    if ($form->isSubmitted() && $form->isValid()) {
      $context = [
        'note' => $badreview->get('note')->getData(),
        'lieu_rdv' => $structure->getName(),
        'date_rdv' => $badreview->get('date_rdv')->getData(),
        'message' => $badreview->get('message')->getData(),
      ];

      $sendMailService->send(
        'noreply@usygec.fr',                    //from
        $userMail,                              //to
        'Retour de l\'enquète de satisfaction', //subject
        'badreview_template',                   //template
        $context                                //context
      );
      $this->addFlash('success', 'Votre mail a bien été envoyé');
      return $this->redirectToRoute('exit');
    }

    return $this->render('ezreview/badreview_form.html.twig', [
      'form' => $form->createView(),
      'structure' => $structure
    ]);
  }

  #[Route("/exit ", name: "exit")]
  public function exit(): Response
  {
    return $this->render('ezreview/exit.html.twig');
  }

  #[Route("admin/ezreview/landding", name: "ezreview_landing")]
  public function ezreview(): Response
  {
    return $this->redirectToRoute('ezreview_hp');
  }

  /******************************************************************************/

  private function getEmailsArray($newFilename)
  {
    $reader = Reader::createFromPath('uploads/csv/' . $newFilename, 'r');
    $emailpattern = '/[a-z0-9_\-\+\.]+@[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i';
    preg_match_all($emailpattern, $reader, $matches);
    $emails = $matches[0];

    return $emails;
  }

  private function deleteFile(string $filename)
  {
    $filesystem = new Filesystem();
    $filesystem->remove(['uploads/csv/' . $filename]);
  }

  private function getNewFileName($csvFile, $slugger)
  {
    $originalFilename = pathinfo($csvFile->getClientOriginalName(), PATHINFO_FILENAME);

    $safeFilename = $slugger->slug($originalFilename);
    $newFilename = $safeFilename . '-' . uniqid() . '.' . $csvFile->guessExtension();

    $csvFile->move(
      $this->getParameter('csv_directory'),
      $newFilename
    );
    return $newFilename;
  }
}
