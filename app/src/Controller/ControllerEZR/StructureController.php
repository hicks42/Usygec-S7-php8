<?php

namespace App\Controller\ControllerEZR;

use App\Entity\EntityEZR\Structure;
use App\Repository\RepositoryEZR\StructureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StructureController extends AbstractController
{
    #[Route("/structure/", name:"structure_index", methods:["GET"])]
    #[IsGranted('ROLE_EZR')]
    public function index(StructureRepository $structureRepository): Response
    {
        return $this->render('structure/index.html.twig', [
            'structures' => $structureRepository->findAll(),
        ]);
    }

    #[Route("/structure/{id}", name:"structure_show", methods:["GET"])]
    #[IsGranted('ROLE_EZR')]
    public function show(Structure $structure): Response
    {
        return $this->render('structure/show.html.twig', [
            'structure' => $structure,
        ]);
    }

    #[Route("/structure/{id}", name:"structure_delete", methods:["POST"])]
    #[IsGranted('ROLE_EZR')]
    public function delete(Request $request, Structure $structure, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $structure->getId(), $request->request->get('_token'))) {
            $entityManager->remove($structure);
            $entityManager->flush();
        }

        return $this->redirectToRoute('structure_index', [], Response::HTTP_SEE_OTHER);
    }
}
