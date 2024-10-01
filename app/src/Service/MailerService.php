<?php

namespace App\Service;

use Twig\Environment;
use App\Entity\EntityEZR\Structure;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Crypto\DkimSigner;
use Symfony\Component\Mime\Crypto\DkimOptions;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MailerService
{
  private $twig;
  private MailerInterface $mailer;
  private EntityManagerInterface $em;
  private $dkim_key_path;
  private $project_dir;
  private $parameterBag;

  public function __construct(MailerInterface $mailer, EntityManagerInterface $em, Environment $twig, $dkim_key_path, $project_dir, ParameterBagInterface $parameterBag)
  {
    $this->mailer = $mailer;
    $this->em = $em;
    $this->twig = $twig;
    $this->dkim_key_path = $dkim_key_path;
    $this->project_dir = $project_dir;
    $this->parameterBag = $parameterBag;
  }

  public function sendOne($target, $context)
  {
    $this->send(
      'noreply@usygec.fr',                //from
      $target,                            //to
      'Enquète de satisfaction ',         //subject
      'ezreview_template',                //template
      $context,                           //context
    );
  }

  // public function sendToTarget($target, $structureId, $baseUrl)
  // {
  //     $structure = $this->em->find(Structure::class, $structureId);
  //     $userMail = $structure->getUser()->getEmail();
  //     $target = $target;

  //     $context = [
  //         'mail' => $target,
  //         'baseUrl' => $baseUrl,
  //         'structure' => $structure->getName(),
  //         'imageName' => $structure->getImageName(),
  //         'googleUrl' => $structure->getGooglUrl(),
  //         'badRevUrl' => $structure->getBadRevUrl(),
  //         'subject' => 'Enquète de satisfaction',
  //         'structureId' => $structureId,
  //     ];

  //     $seconds = rand(2, 7);
  //     sleep($seconds);

  //     $this->send(
  //         $userMail,                          //from
  //         $target,                            //to
  //         'Enquète de satisfaction ',         //subject
  //         'ezreview_template',                //template
  //         $context                            //context
  //     );
  // }

  public function send(
    string $from,
    string $to,
    string $subject,
    string $template,
    array $context
  ): void {

    // On crée le mail
    $email = (new TemplatedEmail())
      ->from($from)
      ->to($to)
      ->subject($subject)
      // ->htmlTemplate("emails/" . $template . ".html.twig")
      ->html($this->twig->render(
        "main/emails/" . $template . ".html.twig",
        [
          'context' => $context,
        ]
      ));

    // if ($this->parameterBag->get('kernel.environment') === 'prod') {
    //   $signer = new DkimSigner('file://' . dirname(__DIR__) . $this->dkim_key_path, 'usygec.fr', 'email');
    // } else {
    //   $signer = new DkimSigner('file://' . $this->project_dir . $this->dkim_key_path, 'usygec.fr', 'email');
    // }

    // $signedEmail = $signer->sign(
    //   $email,
    //   (new DkimOptions())
    //     ->bodyCanon('relaxed')
    //     ->headerCanon('relaxed')
    //     ->headersToIgnore(['Message-ID'])
    //     ->toArray()
    // );
    // if ($transport !== "") {
    //   $signedEmail->getHeaders()->addTextHeader('X-Transport', $transport);
    // }

    $this->mailer->send($email);
  }
}
