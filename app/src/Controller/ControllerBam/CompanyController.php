<?php

namespace App\Controller\ControllerBam;

use App\Entity\User;
use App\Form\FormBam\CsvType;
use App\Form\FormBam\ClientType;
use App\Entity\EntityBam\Company;
use App\Form\FormBam\CompanyType;
use App\Entity\EntityBam\Activity;
use App\Entity\EntityBam\Category;
use App\Form\FormBam\ActivityType;
use App\Repository\UserRepository;
use App\Service\CompanyCsvManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\VarDumper\VarDumper;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\RepositoryBam\CompanyRepository;
use App\Repository\RepositoryBam\ActivityRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompanyController extends AbstractController
{

  private $security;
  private $managerRegistry;

  public function __construct(Security $security, ManagerRegistry $managerRegistry)
  {
    $this->security = $security;
    $this->managerRegistry = $managerRegistry;
  }

  #[Route("/companies/", name: "app_companies", methods: ["GET", "POST"])]
  #[IsGranted('ROLE_BAM')]
  public function index(CompanyRepository $companyRepository, Request $request, PaginatorInterface $paginator, CompanyCsvManager $companyCsvImporter): Response
  {
    $user = $this->security->getUser();

    ////////  search bar  /////////////////////////
    $searchName = $request->query->get('name');
    $searchCategory = $request->query->get('category');
    $sortBy = $request->query->get('sort_by', 'name'); // Default to sorting by name
    $sortOrder = $request->query->get('sort_order', 'asc'); // Default to ascending order

    $nameSortOrder = $sortOrder === 'asc' ? 'desc' : 'asc';

    $searchResult = $companyRepository->findBySearchCriteria($user, $searchName, $searchCategory, $sortBy, $sortOrder);

    ///////////////////////// toggle page : index / searchResult /////////////////////////
    if (!empty($searchName) || !empty($searchCategory)) {
      $userCompanies = $searchResult;
    } else {
      $userCompanies = $companyRepository->findBy(['handler' => $user], ['name' => $sortOrder]);
    }

    // Sort the $userCompanies array based on the selected criteria
    if ($sortBy === 'activitiesCount') {
      usort($userCompanies, function ($a, $b) use ($sortOrder) {
        $aActiveCount = count(array_filter($a->getActivities()->toArray(), function ($activity) {
          return $activity->isActive();
        }));
        $bActiveCount = count(array_filter($b->getActivities()->toArray(), function ($activity) {
          return $activity->isActive();
        }));

        if ($sortOrder === 'asc') {
          return $aActiveCount - $bActiveCount;
        } else {
          return $bActiveCount - $aActiveCount;
        }
      });
    } elseif ($sortBy === 'name') {
      usort($userCompanies, function ($a, $b) use ($sortOrder) {
        return strcasecmp($a->getName(), $b->getName()) * ($sortOrder === 'asc' ? 1 : -1);
      });
    }

    ///////////////////////// Category search select /////////////////////////
    $categories = $this->managerRegistry->getRepository(Category::class)->findAll();
    $categoryNames = [];
    foreach ($categories as $category) {
      $categoryNames[] = $category->getName();
    }

    $filteredResult = [];
    // foreach ($result['allUserCompanies'] as $company) {
    foreach ($userCompanies as $company) {
      $activitiesCount = 0;

      foreach ($company->getActivities() as $activity) {
        if ($activity->isActive()) {
          $activitiesCount++;
        }
      }

      $filteredResult[$company->getId()] = [
        'company' => $company,
        'activitiesCount' => $activitiesCount,
      ];
    }

    // import csf form
    $formcsv = $this->createForm(CsvType::class);
    $formcsv->handleRequest($request);

    if ($formcsv->isSubmitted()) {
      error_log('=== CSV Form submitted ===');

      if (!$formcsv->isValid()) {
        $errors = [];
        foreach ($formcsv->getErrors(true) as $error) {
          $errors[] = $error->getMessage();
        }
        error_log('Form validation errors: ' . implode(', ', $errors));
        $this->addFlash('error', 'Formulaire invalide : ' . implode(', ', $errors));
        return $this->redirectToRoute('app_companies', ["user" => $user], Response::HTTP_SEE_OTHER);
      }

      /** @var UploadedFile */
      $csvFile = $formcsv->get('csvFile')->getData();

      if (!$csvFile) {
        error_log('No file uploaded');
        $this->addFlash('error', 'Aucun fichier n\'a été téléchargé');
        return $this->redirectToRoute('app_companies', ["user" => $user], Response::HTTP_SEE_OTHER);
      }

      error_log('Processing CSV file: ' . $csvFile->getClientOriginalName());

      try {
        $result = $companyCsvImporter->importCompaniesFromCsv($csvFile, $user);
        error_log('Import result: ' . json_encode($result));

        // Si succès complet (aucune erreur)
        if ($result['count'] > 0 && empty($result['errors'])) {
          if ($result['skipped'] > 0) {
            $this->addFlash('success', sprintf('%d société(s) importée(s) avec succès, %d doublon(s) ignoré(s)',
              $result['count'], $result['skipped']));
          } else {
            $this->addFlash('success', sprintf('%d société(s) importée(s) avec succès', $result['count']));
          }
          return $this->redirectToRoute('app_companies', ["user" => $user], Response::HTTP_SEE_OTHER);
        }

        // Si des erreurs existent, afficher la modal
        if (!empty($result['errors'])) {
          return $this->render('bam/companies/index.html.twig', [
            'formcsv' => $formcsv->createView(),
            'user' => $user,
            'pagination' => $paginator->paginate(
              $filteredResult,
              $request->query->getInt('page', 1),
              10
            ),
            'categories' => $categories,
            'sort_order' => $sortOrder,
            'sort_by' => $sortBy,
            'name_sort_order' => $nameSortOrder,
            'width_size' => 'full',
            'csv_import_result' => $result
          ]);
        }

        // Si aucune société importée mais pas d'erreurs structurelles
        if ($result['count'] == 0) {
          $this->addFlash('warning', sprintf(
            'Aucune société importée. %d doublon(s) ignoré(s).',
            $result['skipped']
          ));
        }

        return $this->redirectToRoute('app_companies', ["user" => $user], Response::HTTP_SEE_OTHER);

      } catch (\Exception $e) {
        error_log('CSV Import exception: ' . $e->getMessage());
        error_log('Exception trace: ' . $e->getTraceAsString());

        // Préparer les erreurs pour la modal
        $errorResult = [
          'success' => false,
          'count' => 0,
          'errors' => [[
            'type' => 'exception',
            'message' => 'Erreur critique lors de l\'import',
            'details' => $e->getMessage(),
            'solution' => 'Vérifiez le format de votre fichier CSV'
          ]],
          'skipped' => 0,
          'duplicates' => [],
          'totalLines' => 0,
          'invalidLines' => 0,
          'emptyLines' => 0,
        ];

        return $this->render('bam/companies/index.html.twig', [
          'formcsv' => $formcsv->createView(),
          'user' => $user,
          'pagination' => $paginator->paginate(
            $filteredResult,
            $request->query->getInt('page', 1),
            10
          ),
          'categories' => $categories,
          'sort_order' => $sortOrder,
          'sort_by' => $sortBy,
          'name_sort_order' => $nameSortOrder,
          'width_size' => 'full',
          'csv_import_result' => $errorResult
        ]);
      }
    }
    // Paginate the filtered result
    $pagination = $paginator->paginate(
      $filteredResult, // Query or result to paginate
      $request->query->getInt('page', 1), // Current page number
      10 // Number of items per page
    );

    return $this->render('bam/companies/index.html.twig', [
      'formcsv' => $formcsv->createView(),
      'user' => $user,
      'pagination' => $pagination,
      'categories' => $categories,
      'sort_order' => $sortOrder,
      'sort_by' => $sortBy,
      'name_sort_order' => $nameSortOrder,
      'width_size' => 'full'
    ]);
  }

  #[Route("/companies/new", name: "app_companies_new", methods: ["GET", "POST"])]
  #[IsGranted('ROLE_USER')]
  public function new(Request $request, CompanyRepository $companyRepository): Response
  {
    $company = new Company();
    $form = $this->createForm(CompanyType::class, $company);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $company->setHandler($this->security->getUser());

      $companyRepository->add($company, true);

      // Get the generated ID of the new company
      $companyId = $company->getId();

      return $this->redirectToRoute('app_companies_show', ['id' => $companyId], Response::HTTP_SEE_OTHER);
    }

    return $this->render('bam/companies/new.html.twig', [
      'company' => $company,
      'form' => $form,
    ]);
  }

  #[Route("/companies/{id}/show", name: "app_companies_show", methods: ["GET", "POST"])]
  #[IsGranted('ROLE_USER')]
  public function show(Company $company, Request $request, EntityManagerInterface $em, ActivityRepository $activityRepository, $id): Response
  {
    $token = $this->container->get('security.token_storage')->getToken();
    if ($token->getUser()->getEmail() !== $this->getUser()->getUserIdentifier()) {
      $this->addFlash('error', ' Le token d\'impersonation est manquant ou invalide.');
      return $this->redirectToRoute('home');
    }

    $activity = new Activity();
    // $dbactivities = $activityRepository->findBy(['company' => $company]);
    $form = $this->createForm(ClientType::class, $company, ['method' => 'POST']);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $activities = $company->getActivities();
      if (count($activities) === 0) {
        $company->resetActivities();
      } else {
        foreach ($activities as $key => $activity) {
          $activity->setCompany($company);
          $activities->set($key, $activity);
        }
        $activityRepository->add($activity, true);
      }

      $em->flush();

      $this->addFlash('success', 'Situation Enregistrée');
      return $this->redirectToRoute('app_companies_show', ["id" => $id], Response::HTTP_SEE_OTHER);
    }

    return $this->render('bam/companies/show.html.twig', [
      'form' => $form,
      'company' => $company,
    ]);
  }

  #[Route("/companies/{id<[0-9]+>}/edit", name: "app_companies_edit", methods: ["GET", "POST"])]
  #[IsGranted('ROLE_USER')]
  public function edit(Request $request, Company $company, CompanyRepository $companyRepository, $id): Response
  {

    $form = $this->createForm(CompanyType::class, $company);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $companyRepository->add($company, true);

      return $this->redirectToRoute('app_companies_show', ["id" => $id], Response::HTTP_SEE_OTHER);
    }

    return $this->render('bam/companies/edit.html.twig', [
      'company' => $company,
      'form' => $form,
    ]);
  }

  #[Route("/companies/csv/export", name: "csv_export")]
  #[IsGranted('ROLE_USER')]
  public function exportCompanies(CompanyCsvManager $companyCsvExporter): Response
  {
    $user = $this->security->getUser();
    return $companyCsvExporter->exportCompaniesToCsv($user);
  }

  #[Route("/companies/{id<[0-9]+>}/delete", name: "app_companies_delete", methods: ["POST"])]
  #[IsGranted('ROLE_USER')]
  public function delete(Request $request, Company $company, CompanyRepository $companyRepository): Response
  {
    if ($this->isCsrfTokenValid('delete' . $company->getId(), $request->request->get('_token'))) {
      $companyRepository->remove($company, true);
    }

    return $this->redirectToRoute('app_activities', [], Response::HTTP_SEE_OTHER);
  }
}
