<?php

namespace App\Repository;

use App\Entity\Seleccion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Seleccion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Seleccion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Seleccion[]    findAll()
 * @method Seleccion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeleccionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Seleccion::class);
    }

    // /**
    //  * @return Seleccion[] Returns an array of Seleccion objects
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
    public function findOneBySomeField($value): ?Seleccion
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
