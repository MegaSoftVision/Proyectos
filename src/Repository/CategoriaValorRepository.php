<?php

namespace App\Repository;

use App\Entity\CategoriaValor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategoriaValor|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoriaValor|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoriaValor[]    findAll()
 * @method CategoriaValor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriaValorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoriaValor::class);
    }

    // /**
    //  * @return CategoriaValor[] Returns an array of CategoriaValor objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CategoriaValor
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
