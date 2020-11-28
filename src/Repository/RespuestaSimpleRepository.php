<?php

namespace App\Repository;

use App\Entity\RespuestaSimple;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RespuestaSimple|null find($id, $lockMode = null, $lockVersion = null)
 * @method RespuestaSimple|null findOneBy(array $criteria, array $orderBy = null)
 * @method RespuestaSimple[]    findAll()
 * @method RespuestaSimple[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RespuestaSimpleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RespuestaSimple::class);
    }

    // /**
    //  * @return RespuestaSimple[] Returns an array of RespuestaSimple objects
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
    public function findOneBySomeField($value): ?RespuestaSimple
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
