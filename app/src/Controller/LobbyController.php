<?php

namespace App\Controller;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LobbyController extends AbstractController
{
    #[Route("/lobby", name:"lobby")]
    #[IsGranted('ROLE_USER')]
    public function index(Security $security): Response
    {
        $user = $security->getUser();
        return $this->render('main/lobby.html.twig', [
            'user' => $user,
        ]);
    }
    #[Route("/test", name:"test")]
    // #[IsGranted('ROLE_USER')]
    public function test(Security $security): Response
    {
        $user = $security->getUser();
        return $this->render('test/test.html.twig', [
            'user' => $user,
        ]);
    }
}
