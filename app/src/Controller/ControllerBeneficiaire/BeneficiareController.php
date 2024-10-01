<?php

namespace App\Controller\ControllerBeneficiaire;

use App\Form\FormBeneficiaire\BeneficiaireType;
use App\Service\PdfGeneratorService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;

class BeneficiareController extends AbstractController
{
  #[Route('/beneficiare', name: 'app_beneficiare')]
  public function index(): Response
  {
    return $this->render('beneficiare/index.html.twig', [
      'controller_name' => 'BeneficiareController',
    ]);
  }

  #[Route('/beneficiare-input', name: 'app_beneficiare_input')]
  public function formulaire(Request $request, SessionInterface $session): Response
  {
    $form = $this->createForm(BeneficiaireType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $data = $form->getData();

      $session->set('beneficiare_data', $data);

      return $this->redirectToRoute('app_beneficiare_summary');
    }

    return $this->render('beneficiare/benef_form.html.twig', [
      'form' => $form->createView(),
    ]);
  }

  #[Route('/beneficiare-summary', name: 'app_beneficiare_summary')]
  public function summary(SessionInterface $session): Response
  {
    $data = $session->get('beneficiare_data');

    if (!$data) {
      return $this->redirectToRoute('app_beneficiare_input');
    }

    return $this->render('beneficiare/benef_summary.html.twig', [
      'data' => $data,
    ]);
  }

  #[Route('/generate-simlple-pdf', name: 'app_generate_simple_pdf')]
  public function generateSimplePdf(SessionInterface $session, PdfService $pdfService): Response
  {
    $data = $session->get('beneficiare_data');

    if (!$data) {
      return $this->redirectToRoute('app_beneficiare_input');
    }
    $pdfContent = $pdfService->generatePdf('beneficiare/benef_summary_pdf.html.twig', ['data' => $data]);

    return new Response($pdfContent, 200, [
      'Content-Type' => 'application/pdf',
      'Content-Disposition' => 'attachment; filename="recapitulatif.pdf"'
    ]);
  }

  #[Route('/generate-pdf', name: 'app_generate_pdf')]
  public function generatePdf(Session $session, PdfGeneratorService $pdfGeneratorService): Response
  {
    $data = $session->get('beneficiare_data');
    $html = $this->renderView('beneficiare/benef_summary_pdf.html.twig', ['data' => $data]);

    if (!$data) {
      return $this->redirectToRoute('app_beneficiare_input');
    }
    $content = $pdfGeneratorService->getPdf($html);

    return new Response($content, 200, [
      'Content-Type' => 'application/pdf',
      'Content-Disposition' => 'attachment; filename="recapitulatif.pdf"'
    ]);
  }

  #[Route('/stream-pdf', name: 'app_stream_pdf')]
  public function streamPdf(Session $session, PdfGeneratorService $pdfGeneratorService): Response
  {
    $data = $session->get('beneficiare_data');
    $html = $this->renderView('beneficiare/benef_summary_pdf.html.twig', ['data' => $data]);

    if (!$data) {
      return $this->redirectToRoute('app_beneficiare_input');
    }

    return $pdfGeneratorService->getStreamResponse($html, "recapitulatif.pdf");
  }
}
