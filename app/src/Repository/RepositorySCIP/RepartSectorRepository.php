<?php

namespace App\Repository\RepositorySCIP;

use App\Entity\EntitySCIP\RepartSector;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RepartSector|null find($id, $lockMode = null, $lockVersion = null)
 * @method RepartSector|null findOneBy(array $criteria, array $orderBy = null)
 * @method RepartSector[]    findAll()
 * @method RepartSector[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepartSectorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RepartSector::class);
    }

    // /**
    //  * @return RepartSector[] Returns an array of RepartSector objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RepartSector
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
