<?php

namespace App\Repository;

use App\Entity\Syncronization;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Syncronization|null find($id, $lockMode = null, $lockVersion = null)
 * @method Syncronization|null findOneBy(array $criteria, array $orderBy = null)
 * @method Syncronization[]    findAll()
 * @method Syncronization[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SyncronizationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Syncronization::class);
    }

    // /**
    //  * @return Syncronization[] Returns an array of Syncronization objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Syncronization
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
