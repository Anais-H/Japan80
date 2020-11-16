<?php

namespace App\Repository;

use App\Entity\AnimeLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AnimeLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnimeLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnimeLike[]    findAll()
 * @method AnimeLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimeLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnimeLike::class);
    }

    // /**
    //  * @return AnimeLike[] Returns an array of AnimeLike objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AnimeLike
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
