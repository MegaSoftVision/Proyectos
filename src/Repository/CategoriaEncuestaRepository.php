<?php

namespace App\Repository;

use App\Entity\CategoriaEncuesta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategoriaEncuesta|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoriaEncuesta|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoriaEncuesta[]    findAll()
 * @method CategoriaEncuesta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriaEncuestaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoriaEncuesta::class);
    }

    // /**
    //  * @return CategoriaEncuesta[] Returns an array of CategoriaEncuesta objects
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
    public function findOneBySomeField($value): ?CategoriaEncuesta
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
