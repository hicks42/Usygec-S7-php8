<?php

namespace App\Repository\RepositorySCPI;

use App\Entity\EntitySCPI\RepartGeo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RepartGeo|null find($id, $lockMode = null, $lockVersion = null)
 * @method RepartGeo|null findOneBy(array $criteria, array $orderBy = null)
 * @method RepartGeo[]    findAll()
 * @method RepartGeo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepartGeoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RepartGeo::class);
    }

    // /**
    //  * @return RepartGeo[] Returns an array of RepartGeo objects
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
    public function findOneBySomeField($value): ?RepartGeo
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
