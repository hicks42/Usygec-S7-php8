<?php

namespace App\Controller\ControllerEZR;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\RepositoryEZR\StructureRepository;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QRGenController extends AbstractController
{
  #[Route("/ezreview/{id<[0-9]+>}/qr_gen", name:"qr_gen")]
  #[IsGranted('ROLE_USER')]
  public function qrGen(StructureRepository $structureRepo, $id): Response
  {
    $url = $this->generateUrl('survey', ['id' => $id], UrlGeneratorInterface::ABSOLUTE_URL);
    $structure = $structureRepo->findOneById($id);
    
    // Create QR code
    $qrCode = new QrCode($url);
    $writer = new PngWriter();
    
    // Generate QR code
    $result = $writer->write($qrCode);
    $myqrcode = $result->getDataUri();

    return $this->render('ezreview/qr_gen.html.twig', [
      'structure' => $structure,
      'myqrcode' => $myqrcode,
    ]);
  }
}
