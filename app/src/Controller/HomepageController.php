<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomepageController extends AbstractController
{
    #[Route("/", name:"home")]
    public function index(): Response
    {
        return $this->render('main/index.html.twig');
    }
}
