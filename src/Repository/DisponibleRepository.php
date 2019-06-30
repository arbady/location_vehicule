<?php

namespace App\Repository;

use App\Entity\Disponible;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Disponible|null find($id, $lockMode = null, $lockVersion = null)
 * @method Disponible|null findOneBy(array $criteria, array $orderBy = null)
 * @method Disponible[]    findAll()
 * @method Disponible[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DisponibleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Disponible::class);
    }

    // /**
    //  * @return Disponible[] Returns an array of Disponible objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Disponible
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
