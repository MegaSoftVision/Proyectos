<?php

namespace App\Repository;

use App\Entity\Encuesta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Encuesta|null find($id, $lockMode = null, $lockVersion = null)
 * @method Encuesta|null findOneBy(array $criteria, array $orderBy = null)
 * @method Encuesta[]    findAll()
 * @method Encuesta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EncuestaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Encuesta::class);
    }
	public function EncuestaAnalytics($user)
    {
      return $this->getEntityManager()
        ->createQuery(
      		'SELECT encuesta.id, encuesta.descripcion, encuesta.user_id, encuesta.categoria_id WHERE encuesta.user_id : $user'
      );
    }
  	public function EncuestaShow($id)
    {
      return $this->getEntityManager()
        ->createQuery(
      		'SELECT encuesta.id, encuesta.descripcion, encuesta.categoria_id WHERE encuesta.id : $id'
      );
    }
    // /**
    //  * @return Encuesta[] Returns an array of Encuesta objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Encuesta
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
