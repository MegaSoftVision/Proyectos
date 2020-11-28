<?php

namespace App\Repository;

use App\Entity\Valor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Valor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Valor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Valor[]    findAll()
 * @method Valor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ValorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Valor::class);
    }

    // /**
    //  * @return Valor[] Returns an array of Valor objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Valor
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
