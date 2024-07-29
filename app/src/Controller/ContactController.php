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
        $sujet = $contact->get('subject')->getData();

        // dd($contact->get('e_mail')->getData());   //OK

        if ($form->isSubmitted() && $form->isValid()) {
            $context = [
                'mail' => $contact->get('email')->getData(),
                'name' => $contact->get('name')->getData(),
                'phone' => $contact->get('phone')->getData(),
                'subject' => $contact->get('subject')->getData(),
                'message' => $contact->get('message')->getData(),
            ];

            $mailService->send(
                $contact->get('email')->getData(),  //from
                'p.gerin@usygec.fr',                //to
                'Mail de usygec.fr : ' . $sujet,    //subject
                'contact_template',                 //template
                $context                            //context
            );

            $this->addFlash('success', 'Votre mail a bien été envoyé');
            return $this->redirectToRoute('home');
        }

        return $this->render('main/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
