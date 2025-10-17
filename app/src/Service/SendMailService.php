<?php

namespace App\Service;

use Twig\Environment;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Crypto\DkimSigner;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Crypto\DkimOptions;

class SendMailService
{
  private $twig;
  private MailerInterface $mailer;
  private $dkim_key_path;
  private $project_dir;
  private LoggerInterface $logger;

  public function __construct(MailerInterface $mailer, Environment $twig, $dkim_key_path, $project_dir, LoggerInterface $logger)
  {
    $this->mailer = $mailer;
    $this->twig = $twig;
    $this->dkim_key_path = $dkim_key_path;
    $this->project_dir = $project_dir;
    $this->logger = $logger;
  }

  public function send(
    string $from,
    string $to,
    string $subject,
    string $template,
    array $context,
    ?string $replyTo = null
  ): void {
    try {
      $this->logger->info('Début de l\'envoi d\'email', [
        'from' => $from,
        'to' => $to,
        'subject' => $subject,
        'template' => $template,
        'replyTo' => $replyTo
      ]);

      // On crée le mail
      $email = (new TemplatedEmail())
        ->from($from)
        ->to($to)
        ->subject($subject)
        ->html($this->twig->render(
          "main/emails/" . $template . ".html.twig",
          [
            'context' => $context,
          ]
        ));

      // Ajouter Reply-To si fourni
      if ($replyTo) {
        $email->replyTo($replyTo);
      }

      // Vérification de l'existence de la clé DKIM
      $dkimKeyPath = $this->project_dir . $this->dkim_key_path;
      if (!file_exists($dkimKeyPath)) {
        $this->logger->error('Clé DKIM introuvable', ['path' => $dkimKeyPath]);
        throw new \RuntimeException("Clé DKIM introuvable au chemin: {$dkimKeyPath}");
      }

      $this->logger->info('Signature DKIM du mail', ['dkim_path' => $dkimKeyPath]);

      // Utiliser le chemin DKIM configuré dans .env pour tous les environnements
      $signer = new DkimSigner('file://' . $dkimKeyPath, 'usygec.fr', 'email');

      $signedEmail = $signer->sign(
        $email,
        (new DkimOptions())
          ->bodyCanon('relaxed')
          ->headerCanon('relaxed')
          ->headersToIgnore(['Message-ID'])
          ->toArray()
      );

      // On envoie le mail
      $this->logger->info('Envoi du mail signé');
      $this->mailer->send($signedEmail);
      $this->logger->info('Mail envoyé avec succès');

    } catch (\Exception $e) {
      $this->logger->error('Erreur lors de l\'envoi du mail', [
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
      ]);
      throw $e;
    }
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
