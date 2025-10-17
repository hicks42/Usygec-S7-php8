<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Service\SendMailService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{

    #[Route("/contact", name:"contact")]
    public function index(Request $request, SendMailService $mailService): Response
    {
        $form = $this->createForm(ContactType::class);
        $contact = $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $context = [
                        'mail' => $contact->get('email')->getData(),
                        'name' => $contact->get('name')->getData(),
                        'phone' => $contact->get('phone')->getData(),
                        'subject' => $contact->get('subject')->getData(),
                        'message' => $contact->get('message')->getData(),
                    ];

                    $sujet = $contact->get('subject')->getData();

                    $mailService->send(
                        'site-usygec@usygec.fr',            //from (domaine authentifié)
                        'p.gerin@usygec.fr',                //to
                        'Mail de usygec.fr : ' . $sujet,    //subject
                        'contact_template',                 //template
                        $context,                           //context
                        $contact->get('email')->getData()   //replyTo (adresse du visiteur)
                    );

                    $this->addFlash('success', 'Votre mail a bien été envoyé');
                    return $this->redirectToRoute('home');
                } catch (\Exception $e) {
                    $this->addFlash('error', 'Erreur lors de l\'envoi : ' . $e->getMessage());
                }
            } else {
                $this->addFlash('error', 'Le formulaire contient des erreurs. Veuillez vérifier les champs.');
            }
        }

        return $this->render('main/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
