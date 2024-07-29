<?php

namespace App\Repository\RepositoryBam;

use App\Entity\User;
use App\Entity\EntityBam\Category;
use App\Entity\EntityBam\Company;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Company>
 *
 * @method Company|null find($id, $lockMode = null, $lockVersion = null)
 * @method Company|null findOneBy(array $criteria, array $orderBy = null)
 * @method Company[]    findAll()
 * @method Company[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, Company::class);
  }

  public function add(Company $entity, bool $flush = false): void
  {
    $this->getEntityManager()->persist($entity);

    if ($flush) {
      $this->getEntityManager()->flush();
    }
  }

  public function remove(Company $entity, bool $flush = false): void
  {
    $this->getEntityManager()->remove($entity);

    if ($flush) {
      $this->getEntityManager()->flush();
    }
  }

  public function findByUserCompanies(User $user)
  {
    $qbWithReminder = $this->createQueryBuilder('c');
    $qbWithoutReminder = $this->createQueryBuilder('c');
    $qbWithoutActivities = $this->createQueryBuilder('c');

    $companiesWithReminder = $qbWithReminder
      ->join('c.activities', 'a')
      ->where('c.handler = :user')
      ->andWhere('a.reminder IS NOT NULL')
      ->andWhere('a.isActive = :isActive')
      ->setParameter('isActive', true)
      ->setParameter('user', $user)
      ->orderBy('a.reminder', 'ASC')
      ->getQuery()
      ->getResult();

    $companiesWithoutReminder = $qbWithoutReminder
      ->resetDQLPart('where')
      ->where('c.handler = :user')
      ->leftJoin('c.activities', 'a')
      ->andWhere('a.reminder IS NULL')
      ->andWhere('a.id IS NOT NULL')
      ->andWhere('a.isActive = :isActive')
      ->setParameter('isActive', true)
      ->setParameter('user', $user)
      ->getQuery()
      ->getResult();

    $companiesWithoutActivities = $qbWithoutActivities
      ->resetDQLPart('where')
      ->where('c.handler = :user')
      ->leftJoin('c.activities', 'a')
      ->andWhere('a.id IS NULL')
      ->andWhere('a.isActive = :isActive')
      ->setParameter('isActive', true)
      ->setParameter('user', $user)
      ->getQuery()
      ->getResult();

    return [
      'companiesWithReminder' => $companiesWithReminder,
      'companiesWithoutReminder' => $companiesWithoutReminder,
      'companiesWithoutActivities' => $companiesWithoutActivities,
      'allUserCompanies' => array_merge($companiesWithReminder, $companiesWithoutReminder, $companiesWithoutActivities)
    ];
  }

  public function findBySearchCriteria($user, $searchName, $searchCategory)
  {
    $qb = $this->createQueryBuilder('c')
      ->andWhere('c.handler = :user')
      ->setParameter('user', $user);

    if ($searchName) {
      $qb->andWhere('c.name LIKE :searchName')
        ->setParameter('searchName', '%' . $searchName . '%');
    }

    if ($searchCategory) {
      $category = $this->getEntityManager()
        ->getRepository(Category::class)
        ->findOneBy(['name' => $searchCategory]);

      if ($category) {
        $qb->andWhere('c.category = :searchCategory')
          ->setParameter('searchCategory', $category);
      }
    }

    return $qb->getQuery()->getResult();
  }

  //    /**
  //     * @return Company[] Returns an array of Company objects
  //     */
  //    public function findByExampleField($value): array
  //    {
  //        return $this->createQueryBuilder('c')
  //            ->andWhere('c.exampleField = :val')
  //            ->setParameter('val', $value)
  //            ->orderBy('c.id', 'ASC')
  //            ->setMaxResults(10)
  //            ->getQuery()
  //            ->getResult()
  //        ;
  //    }

  //    public function findOneBySomeField($value): ?Company
  //    {
  //        return $this->createQueryBuilder('c')
  //            ->andWhere('c.exampleField = :val')
  //            ->setParameter('val', $value)
  //            ->getQuery()
  //            ->getOneOrNullResult()
  //        ;
  //    }
}
