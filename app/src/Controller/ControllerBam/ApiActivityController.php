<?php

namespace App\Controller\ControllerBam;

use App\Entity\Company;
use Psr\Log\LoggerInterface;
use App\Entity\EntityBam\Activity;
use App\Form\FormBam\ActivityType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\RepositoryBam\ActivityRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiActivityController extends AbstractController
{

  private $security;
  private $user;
  private $logger;

  public function __construct(Security $security, LoggerInterface $logger)
  {
    $this->security = $security;
    $this->logger = $logger;
    $this->user = $this->security->getUser();
  }

  #[Route("/api/activities", name: "api_activities_api", methods: ["GET"])]
  public function ajaxSortActivities(ActivityRepository $activityRepository, Request $request): Response
  {
    $headers = $request->headers->all();
    $this->logger->info('Request Headers: ' . json_encode($headers));

    $keyword = $request->query->get('keyword');
    $sortBy = $request->query->get('sort_by', 'reminder'); // Default to sorting by name
    $sortOrder = $request->query->get('sort_order', 'desc'); // Default to ascending order

    $activities = $activityRepository->findByKeyword($this->user, $keyword, $sortBy, $sortOrder);

    if ($activities) {
      $now = new \DateTime();
      $daysToReminder = null;
      $activActivities = [];
      $urgentActivities = [];

      foreach ($activities as $activity) {
        //
        if ($activity->getReminder()) {
          $reminderDate = $activity->getReminder();
          $nowDate = $now->setTime(0, 0, 0);
          $reminderDateOnly = $reminderDate->setTime(0, 0, 0);

          $daysToReminder = $reminderDateOnly->diff($nowDate)->days;

          if ($reminderDate < $now) {
            $daysToReminder = "+" . $daysToReminder;
          }

          if ($daysToReminder <= 10) {
            $urgentActivities[] = [
              'activity' => $activity,
              'daysToReminder' => $daysToReminder,
            ];
          } else {
            $reminderActivities[] = [
              'activity' => $activity,
              'daysToReminder' => null,
            ];
          }
        } else {
          $activActivities[] = [
            'activity' => $activity,
            'daysToReminder' => null,
          ];
        }
      }
      $allActivities = array_merge(array_reverse($urgentActivities), $reminderActivities, $activActivities);

      $responseData = [];

      foreach ($allActivities as $item) {
        $activity = $item['activity'];
        $daysToReminder = $item['daysToReminder'];

        $responseData[] = [
          'id' => $activity->getId(),
          'isActive' => $activity->isActive(),
          'name' => $activity->getName(),
          'company' => $activity->getCompany()->getName(),
          'description' => $activity->getDescription(),
          'dueDate' => $activity->getDueDate(),
          'reminder' => $activity->getReminder(),
          // 'createdAt' => $activity->getCreatedAt(),
          'updatedAt' => $activity->getUpdatedAt(),
          'daysToReminder' => $daysToReminder,
        ];
      }
      return new JsonResponse($responseData);
    }
    return new JsonResponse('No data');
  }

  #[Route("/api/activity/", name: "api_add_activity", methods: ["POST"])]
  public function new(Request $request, EntityManagerInterface $em, SerializerInterface $serializer, ActivityRepository $activityRepository, $id): Response
  {
    $apiInput = $serializer->deserialize($request->getContent(), ApiInput::class, 'json');

    $company = $this->user->getCompany();

    $activity = new Activity();

    $activity->setName($request->request->get('name'));
    $activity->setDescription($request->request->get('description'));
    $activity->setCompany($request->request->get('company'));
    $activity->setReminder($request->request->get('reminder'));
    $activity->setDueDate($request->request->get('dueDate'));
    $activity->setIsActive($request->request->get('isActive'));

    $activityRepository->add($activity, true);

    return $this->redirectToRoute('app_activities', ["id" => $id], Response::HTTP_SEE_OTHER);
  }


  #[Route("/api/activity/{id<[0-9]+>}", name: "api_activities_show", methods: ["GET"])]
  public function show(Activity $activity): Response
  {
    return $this->render('bam/activities/show.html.twig', [
      'activity' => $activity,
    ]);
  }

  #[Route("/api/{id}/edit", name: "api_activities_edit", methods: ["PATCH"])]
  public function edit(Request $request, EntityManagerInterface $em, Activity $activity, ActivityRepository $activityRepository): Response
  {
    $form = $this->createForm(ActivityType::class, $activity);
    $form->handleRequest($request);
    $company = $activity->getCompany();

    if ($form->isSubmitted() && $form->isValid()) {
      $activityRepository->add($activity, true);

      return $this->redirectToRoute('app_companies_show', ["id" => $company->getId()], Response::HTTP_SEE_OTHER);
    }

    return $this->render('bam/activities/edit.html.twig', [
      'activity' => $activity,
      'company' => $company,
      'form' => $form,
    ]);
  }

  #[Route("/{id}", name: "api_activities_delete", methods: ["DELETE"])]
  public function delete(Request $request, EntityManagerInterface $em, $id): Response
  {
    $activity = $em->getRepository(Activity::class)->find($id);
    $companyId = $activity->getCompany()->getId();
    if ($this->isCsrfTokenValid('delete' . $activity->getId(), $request->request->get('_token'))) {
      $em->remove($activity);
      $em->flush();
    }

    return $this->redirectToRoute('app_activities', ["id" => $companyId], Response::HTTP_SEE_OTHER);
  }
}
