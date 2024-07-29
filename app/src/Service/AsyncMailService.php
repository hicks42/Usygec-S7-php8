<?php

namespace App\Service;

use App\Entity\EntityEZR\Structure;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class AsyncMailService
{
    private MailerInterface $mailer;
    private EntityManagerInterface $em;

    public function __construct(MailerInterface $mailer, EntityManagerInterface $em)
    {
        $this->mailer = $mailer;
        $this->em = $em;
    }

    public function sendToTarget($target, $structureId, $baseUrl)
    {
        $structure = $this->em->find(Structure::class, $structureId);
        $userMail = $structure->getUser()->getEmail();
        $target = $target;

        $context = [
            'mail' => $target,
            'baseUrl' => $baseUrl,
            'structure' => $structure->getName(),
            'imageName' => $structure->getImageName(),
            'googleUrl' => $structure->getGooglUrl(),
            'badRevUrl' => $structure->getBadRevUrl(),
            'subject' => 'Enquète de satisfaction',
            'structureId' => $structureId,
        ];

        $seconds = rand(2, 7);
        sleep($seconds);

        $this->send(
            $userMail,                          //from
            $target,                            //to
            'Enquète de satisfaction ',         //subject
            'ezreview_template',                //template
            $context                            //context
        );
    }

    private function send(
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
            ->htmlTemplate("emails/$template.html.twig")
            ->context($context);

        //On fait passer le mail par mailjet
        $email->getHeaders()->addTextHeader('X-Transport', 'mailjet');

        // On envoie le mail
        $this->mailer->send($email);
    }
}
