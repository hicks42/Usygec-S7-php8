<?php

namespace App\Service;

use Twig\Environment;
use App\Service\MailerService;
use App\Service\PdfGeneratorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Crypto\DkimSigner;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Crypto\DkimOptions;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SendMailService
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

    //Pour faire passer le mail par mailjet
    // $email->getHeaders()->addTextHeader('X-Transport', 'mailjet');
    // $signer = new DkimSigner('file://'.dirname(__DIR__).$this->dkim_key_path, 'usygec.fr', 'email');

    if ($this->parameterBag->get('kernel.environment') === 'prod') {
      $signer = new DkimSigner('file://' . dirname(__DIR__) . '/../../DKIM_key.txt', 'usygec.fr', 'email');
    } else {
      $signer = new DkimSigner('file://' . $this->project_dir . $this->dkim_key_path, 'usygec.fr', 'email');
    }

    $signedEmail = $signer->sign(
      $email,
      (new DkimOptions())
        ->bodyCanon('relaxed')
        ->headerCanon('relaxed')
        ->headersToIgnore(['Message-ID'])
        ->toArray()
    );

    // On envoie le mail
    $this->mailer->send($signedEmail);
  }

  public function sendEmailWithPdf(
    $context,
    $pdfAtt
  ): Response {

    $this->sendWithPdfAttachment(
      'noreply@usygec.fr',
      'recipient@example.com',
      'Votre PDF est prêt',
      'email_template',
      // ['someData' => $someData],
      $context,
      $pdfAtt,
      'document.pdf'
    );

    return new Response('Email envoyé avec le PDF en pièce jointe');
  }

  public function sendWithPdfAttachment(
    string $from,
    string $to,
    string $subject,
    string $template,
    array $context,
    string $pdfAtt, // Contenu du PDF en string
    string $pdfFilename
  ): void {
    $email = (new TemplatedEmail())
      ->from($from)
      ->to($to)
      ->subject($subject)
      ->html($this->twig->render("main/emails/" . $template . ".html.twig", [
        'context' => $context,
      ]))
      // Ajouter le PDF comme pièce jointe et spécifier le nom du fichier ici
      ->attach($pdfAtt, $pdfFilename, 'application/pdf');

    // Envoyer l'email
    $this->mailer->send($email);
  }
}
