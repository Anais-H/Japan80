<?php

namespace App\Repository;

use App\Entity\ArtisteLike;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ArtisteLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArtisteLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArtisteLike[]    findAll()
 * @method ArtisteLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtisteLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArtisteLike::class);
    }

    // /**
    //  * @return ArtisteLike[] Returns an array of ArtisteLike objects
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
    public function findOneBySomeField($value): ?ArtisteLike
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
