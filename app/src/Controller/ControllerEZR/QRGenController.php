<?php

namespace App\Controller\ControllerEZR;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\ErrorCorrectionLevel;
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
    $writer = new PngWriter();
    $qrCode = QrCode::create('Life is too short to be generating QR codes')
    ->setEncoding(new Encoding('UTF-8'))
    ->setErrorCorrectionLevel(ErrorCorrectionLevel::Low)
    ->setSize(300)
    ->setMargin(10)
    ->setRoundBlockSizeMode(RoundBlockSizeMode::Margin)
    ->setForegroundColor(new Color(0, 0, 0))
    ->setBackgroundColor(new Color(255, 255, 255));
    $logo = Logo::create('images/companies/tny-logo-usygec.png')
      ->setResizeToWidth(60);

    $qrCode->setSize(400)->setForegroundColor(new Color(0, 0, 0))->setBackgroundColor(new Color(255, 255, 255));
    $myqrcode = $writer->write(
      $qrCode,
    )->getDataUri();

    return $this->render('ezreview/qr_gen.html.twig', [
      'structure' => $structure,
      'myqrcode' => $myqrcode,
    ]);
  }
}
