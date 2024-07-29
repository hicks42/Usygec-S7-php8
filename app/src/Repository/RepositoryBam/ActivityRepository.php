<?php

namespace App\Repository\RepositoryBam;

use App\Entity\User;
use App\Entity\EntityBam\Company;
use App\Entity\EntityBam\Activity;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Activity>
 *
 * @method Activity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Activity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Activity[]    findAll()
 * @method Activity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivityRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, Activity::class);
  }

  public function add(Activity $entity, bool $flush = false): void
  {
    $this->getEntityManager()->persist($entity);

    if ($flush) {
      $this->getEntityManager()->flush();
    }
  }

  public function remove(Activity $entity, bool $flush = false): void
  {
    $this->getEntityManager()->remove($entity);

    if ($flush) {
      $this->getEntityManager()->flush();
    }
  }

  public function countByActiveActivitiesByCompany(Company $company): int
  {
    return $this->createQueryBuilder('a')
      ->select('COUNT(a.id)')
      ->andWhere('a.company = :company')
      ->andWhere('a.isActive = :isActive')
      ->setParameter('company', $company)
      ->setParameter('isActive', true)
      ->getQuery()
      ->getSingleScalarResult();
  }

  public function countByActivitiesDueWithin5Days(Company $company): int
  {
    $now = new \DateTime();
    $fiveDaysFromNow = (clone $now)->modify('+5 days');

    return $this->createQueryBuilder('a')
      ->select('COUNT(a.id)')
      ->andWhere('a.company = :company')
      ->andWhere('a.dueDate BETWEEN :start AND :end')
      ->setParameter('company', $company)
      ->setParameter('start', $now->format('Y-m-d H:i:s'))
      ->setParameter('end', $fiveDaysFromNow->format('Y-m-d H:i:s'))
      ->getQuery()
      ->getSingleScalarResult();
  }

  public function findByCompaniesActivities(User $user)
  {
    $qb = $this->createQueryBuilder('a');

    $activitiesWithReminder = $qb
      ->leftJoin('a.company', 'c')
      ->leftJoin('c.handler', 'u')
      ->where('u.id = :user')
      ->andWhere('a.reminder IS NOT NULL')
      ->andWhere('a.isActive = :isActive')
      ->setParameter('isActive', true)
      ->setParameter('user', $user)
      ->orderBy('a.reminder', 'ASC')
      ->getQuery()
      ->getResult();

    $activitiesWithoutReminder = $qb
      ->resetDQLPart('where')
      ->andWhere('u.id = :user')
      ->andWhere('a.reminder IS NULL')
      ->andWhere('a.isActive = :isActive')
      ->setParameter('isActive', true)
      ->setParameter('user', $user)
      ->getQuery()
      ->getResult();

    return [
      'activitiesWithReminder' => $activitiesWithReminder,
      'activitiesWithoutReminder' => $activitiesWithoutReminder,
      'allActivities' => array_merge($activitiesWithReminder, $activitiesWithoutReminder)
    ];
  }

  public function findByKeyword(User $user, ?string $keyword, ?string $sortBy, ?string $sortOrder): array
  {
    $now = new \DateTime();
    $fiveDaysFromNow = (clone $now)->modify('+5 days');

    $qb = $this->createQueryBuilder('a')
      ->leftJoin('a.company', 'c')
      ->leftJoin('c.handler', 'u')
      ->where('u.id = :user')
      ->andWhere('a.isActive = :isActive')
      ->setParameter('user', $user)
      ->setParameter('isActive', true);

    // Filter by keyword if provided
    if ($keyword) {
      $qb->andWhere($qb->expr()->orX(
        $qb->expr()->like('a.name', ':keyword'),
        $qb->expr()->like('a.description', ':keyword'),
        $qb->expr()->like('c.name', ':keyword')
      ))
        ->setParameter('keyword', '%' . $keyword . '%');
    }

    // Sort the result if sortBy and sortOrder are provided
    if ($sortBy && $sortOrder) {
      // Determine the valid columns for sorting
      $validColumns = ['name', 'company', 'reminder', 'dueDate']; // Add more valid columns if needed

      // Check if the provided sortBy column is valid
      if (in_array($sortBy, $validColumns)) {
        // Determine the valid sortOrder values
        $validSortOrders = ['asc', 'desc'];

        // Check if the provided sortOrder is valid
        if (in_array($sortOrder, $validSortOrders)) {
          $qb->orderBy('a.' . $sortBy, $sortOrder);
        }
      }
    }

    return $qb->getQuery()->getResult();
  }

  public function findByKeywordWithCustomSorting(User $user, ?string $keyword, ?string $sortBy, ?string $sortOrder): array
  {
    $now = new \DateTime();
    $fiveDaysFromNow = (clone $now)->modify('+5 days');

    $qb = $this->createQueryBuilder('a')
      ->leftJoin('a.company', 'c')
      ->leftJoin('c.handler', 'u')
      ->where('u.id = :user')
      ->andWhere('a.isActive = :isActive')
      ->setParameter('user', $user)
      ->setParameter('isActive', true);

    // Filter by keyword if provided
    if ($keyword) {
      $qb->andWhere($qb->expr()->orX(
        $qb->expr()->like('a.name', ':keyword'),
        $qb->expr()->like('a.description', ':keyword'),
        $qb->expr()->like('c.name', ':keyword')
      ))
        ->setParameter('keyword', '%' . $keyword . '%');
    }

    // Handle custom sorting for reminder and dueDate columns
    if ($sortBy && $sortOrder) {
      $validColumns = ['name', 'company', 'reminder', 'dueDate'];

      if (in_array($sortBy, $validColumns)) {
        $qb->addOrderBy('CASE WHEN a.' . $sortBy . ' IS NULL THEN 1 ELSE 0 END', $sortOrder);
        $qb->addOrderBy('a.' . $sortBy, $sortOrder);
      }
    }

    return $qb->getQuery()->getResult();
  }



  //    /**
  //     * @return Activity[] Returns an array of Activity objects
  //     */
  //    public function findByExampleField($value): array
  //    {
  //        return $this->createQueryBuilder('a')
  //            ->andWhere('a.exampleField = :val')
  //            ->setParameter('val', $value)
  //            ->orderBy('a.id', 'ASC')
  //            ->setMaxResults(10)
  //            ->getQuery()
  //            ->getResult()
  //        ;
  //    }

  //    public function findOneBySomeField($value): ?Activity
  //    {
  //        return $this->createQueryBuilder('a')
  //            ->andWhere('a.exampleField = :val')
  //            ->setParameter('val', $value)
  //            ->getQuery()
  //            ->getOneOrNullResult()
  //        ;
  //    }
}
