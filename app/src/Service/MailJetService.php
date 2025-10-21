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
    $structure = $this->structureRepo->findOneById($structureId);

    if ($structure->getBadRevUrl() === "" || $structure->getBadRevUrl() === null) {
      $badUrl = $baseUrl . "/badreview/" . $structureId;
    } else {
      $badUrl = $structure->getBadRevUrl();
    };

    $structureName = $structure->getName();
    $image = $structure->getImageName();

    // En développement (localhost), utiliser une URL placeholder
    // En production, utiliser l'URL réelle du serveur
    if (strpos($baseUrl, 'localhost') !== false) {
      // URL placeholder pour le développement (remplace par ton URL de prod quand tu déploies)
      $imageUrl = 'https://via.placeholder.com/600x200.png?text=' . urlencode($structureName);
    } else {
      // URL de production
      $imageUrl = $baseUrl . "/images/companies/" . $image;
    }
    $GooglUrl = "https://search.google.com/local/writereview?placeid=" . $structure->getPid();

    $mj = new Client($this->mailjet_key_public, $this->mailjet_key_private, true, ["version" => 'v3.1']);

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
            'imageUrl' => $imageUrl,
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
