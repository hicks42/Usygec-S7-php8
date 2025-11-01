<?php

namespace App\Service;

use App\Entity\EntityEZR\Structure;
use App\Repository\RepositoryEZR\StructureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MailgunService
{
  private EntityManagerInterface $em;
  private MailerInterface $mailer;
  private StructureRepository $structureRepo;
  private string $projectDir;

  public function __construct(
    EntityManagerInterface $em,
    StructureRepository $structureRepo,
    MailerInterface $mailer,
    ParameterBagInterface $params
  )
  {
    $this->em = $em;
    $this->mailer = $mailer;
    $this->structureRepo = $structureRepo;
    $this->projectDir = $params->get('kernel.project_dir');
  }

  public function send($baseUrl, $target, $structureId)
  {
    // Vérifier que structureId n'est pas vide
    if (empty($structureId)) {
      throw new \Exception("L'ID de structure est vide ou null");
    }

    $structure = $this->structureRepo->findOneById($structureId);

    if (!$structure) {
      throw new \Exception("Structure non trouvée avec l'ID : " . $structureId);
    }

    // Déterminer l'URL de mauvaise review
    if ($structure->getBadRevUrl() === "" || $structure->getBadRevUrl() === null) {
      $badUrl = $baseUrl . "/badreview/" . $structureId;
    } else {
      $badUrl = $structure->getBadRevUrl();
    }

    // Debug: vérifier que l'URL contient bien l'ID
    if (strpos($badUrl, '/badreview/') !== false && strpos($badUrl, '/badreview/' . $structureId) === false) {
      throw new \Exception("Erreur: l'URL badUrl ne contient pas le structureId. URL: " . $badUrl);
    }

    $structureName = $structure->getName();
    $googleUrl = "https://search.google.com/local/writereview?placeid=" . $structure->getPid();
    $imageName = $structure->getImageName();

    // Chemin absolu vers l'image (accessible en local par PHP)
    $imagePath = $this->projectDir . '/public/images/companies/' . $imageName;

    // Si l'image de la structure n'existe pas, créer une image avec le nom
    if (!$imageName || !file_exists($imagePath)) {
      $imagePath = $this->generatePlaceholderImage($structureName);
    }

    // Créer l'email avec le template Twig
    $email = (new TemplatedEmail())
      ->from(new Address('agence@usygec.fr', 'Isadora de ' . $structureName))
      ->to($target)
      ->subject('Enquête de satisfaction de ' . $structureName)
      ->htmlTemplate('ezreview/emails/enquete_satisfaction.html.twig');

    // Embarquer l'image directement dans l'email (pas besoin d'URL publique)
    $imageEmbedded = $email->embedFromPath($imagePath, 'structure_image');

    // Contexte pour le template Twig
    $context = [
      'structureName' => $structureName,
      'badUrl' => $badUrl,
      'googleUrl' => $googleUrl,
      'hasEmbeddedImage' => true,
      'placeholderUrl' => '' // Non utilisé quand hasEmbeddedImage = true
    ];

    $email->context($context);

    // Envoyer via Symfony Mailer (qui utilisera automatiquement le MAILER_DSN configuré = Mailgun)
    try {
      $this->mailer->send($email);
      return true;
    } catch (\Exception $e) {
      throw new \Exception("Erreur lors de l'envoi de l'email : " . $e->getMessage());
    }
  }

  /**
   * Génère une image placeholder avec le nom de la structure
   * Format 600x200 avec fond bleu foncé et texte blanc centré
   */
  private function generatePlaceholderImage(string $structureName): string
  {
    // Créer une image 600x200
    $width = 600;
    $height = 200;
    $image = imagecreatetruecolor($width, $height);

    // Couleurs
    $bgColor = imagecolorallocate($image, 0, 64, 92); // #00405c (bleu foncé)
    $textColor = imagecolorallocate($image, 255, 255, 255); // Blanc

    // Remplir le fond
    imagefilledrectangle($image, 0, 0, $width, $height, $bgColor);

    // Configurer le texte
    $fontSize = 32;
    $fontPath = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf';

    // Si la police n'existe pas, utiliser une police par défaut
    if (!file_exists($fontPath)) {
      $fontPath = '/usr/share/fonts/truetype/liberation/LiberationSans-Bold.ttf';
    }

    // Calculer la position du texte pour le centrer
    if (file_exists($fontPath)) {
      $bbox = imagettfbbox($fontSize, 0, $fontPath, $structureName);
      $textWidth = abs($bbox[4] - $bbox[0]);
      $textHeight = abs($bbox[5] - $bbox[1]);
      $x = ($width - $textWidth) / 2;
      $y = ($height + $textHeight) / 2;

      // Écrire le texte
      imagettftext($image, $fontSize, 0, $x, $y, $textColor, $fontPath, $structureName);
    } else {
      // Fallback si pas de police TrueType : utiliser imagestring
      $x = ($width - (strlen($structureName) * 9)) / 2;
      $y = ($height - 16) / 2;
      imagestring($image, 5, $x, $y, $structureName, $textColor);
    }

    // Sauvegarder l'image temporaire
    $tempPath = sys_get_temp_dir() . '/placeholder_' . md5($structureName . time()) . '.png';
    imagepng($image, $tempPath);
    imagedestroy($image);

    return $tempPath;
  }
}
