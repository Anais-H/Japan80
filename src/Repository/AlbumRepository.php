<?php

namespace App\Repository;

use App\Entity\Album;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Album|null find($id, $lockMode = null, $lockVersion = null)
 * @method Album|null findOneBy(array $criteria, array $orderBy = null)
 * @method Album[]    findAll()
 * @method Album[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlbumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Album::class);
    }

    /**
    * @return Album[] Returns an array of Album objects
    */
    public function findByArtisteID($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.artiste = :val')
            ->setParameter('val', $value)
            ->orderBy('a.date_sortie', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return Album[] Returns an array of Album objects
    */
    public function findAlbumsByArtisteID($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.artiste = :val')
            ->andWhere('a.type = \'album\'')
            ->setParameter('val', $value)
            ->orderBy('a.date_sortie', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return Album[] Returns an array of Album objects
    */
    public function findSinglesByArtisteID($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.artiste = :val')
            ->andWhere('a.type = \'single\'')
            ->setParameter('val', $value)
            ->orderBy('a.date_sortie', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Album
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
