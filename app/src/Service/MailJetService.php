<?php

namespace App\Service;

// require 'vendor/autoload.php';

use Mailjet\Resources;
use Mailjet\Client;
use App\Entity\EntityEZR\Structure;
use App\Repository\RepositoryEZR\StructureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class MailJetService
{
  private EntityManagerInterface $em;

  private $structureRepo;
  private $mailjet_key_public;
  private $mailjet_key_private;

  public function __construct(EntityManagerInterface $em, StructureRepository $structureRepo, $mailjet_key_public, $mailjet_key_private)
  {
    $this->em = $em;
    $this->structureRepo = $structureRepo;
    $this->mailjet_key_public = $mailjet_key_public;
    $this->mailjet_key_private = $mailjet_key_private;
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
    $imageName = $structure->getImageName();
    $GooglUrl = "https://search.google.com/local/writereview?placeid=" . $structure->getPid();

    // URL placeholder par défaut
    $placeholderUrl = 'https://via.placeholder.com/600x200.png?text=' . urlencode($structureName);

    // Si une image existe, utiliser l'URL publique, sinon utiliser le placeholder
    $hasEmbeddedImage = false;  // On n'utilise pas d'images embarquées à cause des permissions

    $mj = new Client(
      $this->mailjet_key_public,
      $this->mailjet_key_private,
      true,
      [
        "version" => 'v3.1',
        "curl" => [
          CURLOPT_SSL_VERIFYPEER => true,
          CURLOPT_SSL_VERIFYHOST => 2,
          CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_CONNECTTIMEOUT => 10
        ]
      ]
    );

    $body = [
      'Messages' => [
        [
          'From' => [
            'Email' => "agence@usygec.fr",
            'Name' => 'Isadora de ' . $structureName,
          ],
          'To' => [
            [
              'Email' => $target,
              'Name' => "Patrice",
            ]
          ],
          'TemplateID' => 4577295,
          'TemplateLanguage' => true,
          'Subject' => "Enquete de satisfaction de " . $structureName,
          'Variables' => [
            'structureName' => $structureName,
            'hasEmbeddedImage' => $hasEmbeddedImage,
            'placeholderUrl' => $placeholderUrl,
            'badUrl' => $badUrl,
            'googleUrl' => $GooglUrl
          ]
        ]
      ]
    ];
    $response = $mj->post(Resources::$Email, ['body' => $body]);
    $response->success();
  }
}
