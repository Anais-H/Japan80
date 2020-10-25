<?php

namespace App\Repository;

use App\Entity\Artiste;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Artiste|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artiste|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artiste[]    findAll()
 * @method Artiste[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtisteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artiste::class);
    }

    // /**
    //  * @return Artiste[] Returns an array of Artiste objects
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

    
    public function findOneByNom($value): ?Artiste
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.nom = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findByGenre($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.genre = :val')
            ->setParameter('val', $value)
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function findByFirstLetter($value)
    {
        return $this->createQueryBuilder('a')
            ->where('a.nom = :val?')
            ->setParameter('val', $value)
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}