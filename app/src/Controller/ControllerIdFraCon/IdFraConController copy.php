<?php

namespace App\Controller\ControllerIdFraCon;

use App\Service\SendMailService;
use App\Service\PdfGeneratorService;
use App\Form\FormIdFraCon\IdentityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\FormIdFraCon\ClauseParticuliereType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Repository\RepositoryIdFraCon\ClausesRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IdFraConController extends AbstractController
{

  #[Route('/idfracon', name: 'app_idfracon')]
  public function index(SessionInterface $session): Response
  {
    $session->clear();
    return $this->render('idfracon/index.html.twig', [
      'controller_name' => 'IdfraconController',
    ]);
  }

  #[Route('/idfracon-identify', name: 'app_idfracon_identify')]
  public function identify(Request $request, SessionInterface $session): Response
  {
    $form = $this->createForm(IdentityType::class, ['use_as_concubin' => false]);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $userData = $form->getData();
      $session->set('idfracon_user', $userData);
      return $this->redirectToRoute('app_identity_recap');
    }

    return $this->render('idfracon/form/identify_form.html.twig', [
      'form' => $form->createView(),
    ]);
  }

  #[Route('/recap', name: 'app_identity_recap')]
  public function recap(SendMailService $mailerService, PdfGeneratorService $pdfGenerator, SessionInterface $session): Response
  {
    $sessionUser = $session->get('idfracon_user', []);

    if (!$sessionUser) {
      return $this->redirectToRoute('app_idfracon_identify');
    }

    return $this->render('idfracon/identify_recap.html.twig', [
      'data' => $sessionUser
    ]);
  }

  #[Route('/clause-choice', name: 'app_clause_choice')]
  public function clauseChoice(Request $request, ClausesRepository $clausesRepository, SessionInterface $session): Response
  {

    $sessionUser = $session->get('idfracon_user', []);

    if (!$sessionUser) {
      return $this->redirectToRoute('app_idfracon_identify');
    }

    $clauses = $clausesRepository->findAll();

    $formBenef = $this->createForm(IdentityType::class, null, ['use_as_benef' => true]);
    $formClausePart = $this->createForm(ClauseParticuliereType::class);

    $formBenef->handleRequest($request);
    $formClausePart->handleRequest($request);

    if ($request->request->has('clauseId')) {
      $clauseId = $request->request->get('clauseId');
      $session->set('idfracon_clause_id', $clauseId);
    }

    if ($formBenef->isSubmitted() && $formBenef->isValid()) {

      if ($session->get('idfracon_custom_clause')) {
        $session->remove('idfracon_custom_clause');
      };
      $formBenefData = $formBenef->getData();
      $session->set('idfracon_benef_clause', $formBenefData);

      return $this->redirectToRoute('app_final_recap', ['clauseId' => $clauseId]);
    }

    if ($formClausePart->isSubmitted() && $formClausePart->isValid()) {

      if ($session->get('idfracon_benef_clause')) {
        $session->remove('idfracon_benef_clause');
      };
      $formClausePartData = $formClausePart->getData();
      $session->set('idfracon_custom_clause', $formClausePartData);

      return $this->redirectToRoute('app_final_recap', ['clauseId' => $clauseId]);
    }


    return $this->render('idfracon/clause_choice.html.twig', [
      'form' => $formBenef,
      'form_clause_part' => $formClausePart,
      'clauses' => $clauses,
    ]);
  }

  #[Route('/idfracon-final-recap/{clauseId}', name: 'app_final_recap')]
  public function benefSummary(ClausesRepository $clausesRepository, SessionInterface $session, $clauseId): Response
  {
    $session->set('idfracon_clause_id', $clauseId);
    $selectedClause = $clausesRepository->findOneBy(['id' => $clauseId]);
    $sessionUser = $session->get('idfracon_user', []);
    $clauseBenef = $session->get('idfracon_benef_clause');
    $clauseCustom = $session->get('idfracon_custom_clause');
    $formName = $selectedClause->getModal();

    if ($formName == null) {
      $session->remove('idfracon_custom_clause');
      $session->remove('idfracon_benef_clause');
    } else {
      if ($clauseBenef) {
        $session->remove('idfracon_custom_clause');
        $selectedAdd = $clauseBenef;
      } elseif ($clauseCustom) {
        $session->remove('idfracon_benef_clause');
        $selectedAdd = $clauseCustom;
      }
    }

    $session->set('idfracon_form_name', $formName);

    if (!$clauseId) {
      return $this->redirectToRoute('app_clause_choice');
    }

    if (!$sessionUser) {
      return $this->redirectToRoute('app_idfracon_identify');
    }

    return $this->render('idfracon/final_recap.html.twig', [
      'session_user' => $sessionUser,
      'selected_clause' => $selectedClause,
      'selected_add' => $selectedAdd,
      'form_name' => $formName,
      'clause_id' => $clauseId,
    ]);
  }

  #[Route('/stream-pdf', name: 'app_stream_pdf')]
  public function streamPdf(ClausesRepository $clausesRepository, Session $session, PdfGeneratorService $pdfGenerator): Response
  {
    $clauseId = $session->get('idfracon_clause_id');
    $selectedClause = $clausesRepository->findOneBy(['id' => $clauseId]);
    $sessionUser = $session->get('idfracon_user', []);
    $formName = $selectedClause->getModal();

    if (!$sessionUser) {
      return $this->redirectToRoute('app_idfracon_identify');
    }

    if (!$clauseId) {
      return $this->redirectToRoute('app_idfracon');
    }

    if ($formName) {
    }
    $twigTemplate = 'idfracon/pdfs/gle_recap_pdf.html.twig';
    $html = $this->getHtml($twigTemplate, ['clause_id' => $clauseId]);

    return $pdfGenerator->getStreamResponse($html, "recapitulatif.pdf");
  }

  #[Route('/goodbye', name: 'app_goodbye')]
  public function goodbye(Session $session, SendMailService $mailerService, PdfGeneratorService $pdfGenerator): Response
  {
    $sessionData = $session->get('idfracon');

    if (!$sessionData) {
      return $this->redirectToRoute('app_idfracon');
    }
    $twigTemplate = 'idfracon/final_recap_pdf.html.twig';
    $html = $this->getHtml($twigTemplate, ['data' => $sessionData]);

    $pdfAtt = $pdfGenerator->generatePdfAttachment($html);

    $recipient = "patouseul@yahoo.fr";

    try {
      $this->sendEmailWithPdf($mailerService, $pdfAtt, $recipient);
      $this->addFlash('success', 'Votre demande a été traité');
    } catch (\Exception $e) {
      $this->addFlash('error', 'Une erreur est survenue lors de l\'envoi de l\'email : ' . $e->getMessage());
    }

    return $this->redirectToRoute('app_idfracon');
  }

  private function sendEmailWithPdf(
    SendMailService $mailerService,
    $pdfAtt,
    $recipient
  ): void {
    try {
      $mailerService->sendWithPdfAttachment(
        'noreply@usygec.fr',
        $recipient,
        'Votre PDF est prêt',
        'idfracon',
        ['contextKey' => 'contextValue'],
        $pdfAtt,
        'document.pdf'
      );
    } catch (\Exception $e) {
      throw new \Exception('l\'information n\'a put être traitées' . $e->getMessage());
    }
  }

  #[Route('/store-id', name: 'app_store_id', methods: ['POST'])]
  public function storeId(Request $request, SessionInterface $session): JsonResponse
  {
    $data = json_decode($request->getContent(), true);
    $id = $data['id'] ?? null;

    if ($id) {
      $session->set('clause_id', $id);

      return new JsonResponse(['status' => 'success', 'message' => "ID $id stocké dans la session"]);
    }

    return new JsonResponse(['status' => 'error', 'message' => 'ID non fourni'], 400);
  }

  private function getHtml(string $template, $sessionData): string
  {
    return $this->renderView($template, ['data' => $sessionData]);
  }

  // #[Route('/idfracon-identity-recap', name: 'app_identity_recap')]
  // public function identitySummary(): Response
  // {
  //   $sessionData = $session->get('idfracon', []);

  //   if (!$sessionData) {
  //     return $this->redirectToRoute('app_idfracon_identify');
  //   }

  //   return $this->render('idfracon/identify_recap.html.twig', [
  //     'data' => $sessionData,
  //   ]);
  // }

  // #[Route('/generate-simlple-pdf', name: 'app_generate_simple_pdf')]
  // public function generateSimplePdf(PdfService $pdfService): Response
  // {
  //   $sessionData = $session->get('idfracon');

  //   if (!$sessionData) {
  //     return $this->redirectToRoute('app_idfracon');
  //   }
  //   $pdfContent = $pdfService->generatePdf('idfracon/final_recap_pdf.html.twig', ['data' => $sessionData]);

  //   return new Response($pdfContent, 200, [
  //     'Content-Type' => 'application/pdf',
  //     'Content-Disposition' => 'attachment; filename="recapitulatif.pdf"'
  //   ]);
  // }

  // #[Route('/generate-pdf', name: 'app_generate_pdf')]
  // public function generatePdf(Session $session, PdfGeneratorService $pdfGenerator): Response
  // {
  //   $sessionData = $session->get('idfracon');

  //   $twigTemplate = 'idfracon/final_recap_pdf.html.twig';
  //   $html = $this->getHtml($twigTemplate, ['data' => $sessionData]);

  //   if (!$sessionData) {
  //     return $this->redirectToRoute('app_idfracon');
  //   }
  //   $content = $pdfGenerator->getPdf($html);

  //   return new Response($content, 200, [
  //     'Content-Type' => 'application/pdf',
  //     'Content-Disposition' => 'attachment; filename="recapitulatif.pdf"'
  //   ]);
  // }

  // #[Route('/idfracon-input-benef', name: 'app_idfracon')]
  // public function formulaire(Request $request): Response
  // {
  //   $form = $this->createForm(BeneficiaireType::class);
  //   $form->handleRequest($request);

  //   if ($form->isSubmitted() && $form->isValid()) {
  //     $formData = $form->getData();

  //     $session->set('idfracon', $formData);

  //     return $this->redirectToRoute('app_final_recap');
  //   }

  //   return $this->render('idfracon/benef_form.html.twig', [
  //     'form' => $form->createView(),
  //   ]);
  // }

}
