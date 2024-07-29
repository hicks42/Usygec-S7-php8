<?php

namespace App\Controller;

use App\Form\FormBam\CsvType;
use App\Form\UserType;
use App\Service\CompanyCsvManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    #[Route("/usygec/settings", name:"usygec_settings")]
    #[IsGranted('ROLE_ADMIN')]
    public function editUsygecUser(Request $request, CompanyCsvManager $companyCsvImporter): Response
    {
        $user = $this->security->getUser();

        $formcsv = $this->createForm(CsvType::class);
        $formcsv->handleRequest($request);

        if ($formcsv->isSubmitted() && $formcsv->isValid()) {

            /** @var UploadedFile */
            $csvFile = $formcsv->get('csvFile')->getData();
            if ($csvFile) {

                $companyCsvImporter->importCompaniesFromCsv($csvFile, $user);

                $this->addFlash('success', 'Sociétés Enregistrée');
                return $this->redirectToRoute('app_companies', ["user" => $user], Response::HTTP_SEE_OTHER);
            }
            $this->addFlash('error', 'Fichier non conforme');
            return $this->redirectToRoute('ezreview_hp', ["user" => $user], Response::HTTP_SEE_OTHER);
        }

        return $this->render('main/usygec_settings.html.twig', [
            'formcsv' => $formcsv->createView(),
            'user' => $user,
        ]);
    }
}
