<?php

namespace App\Repository;

use App\Entity\Penalisation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Penalisation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Penalisation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Penalisation[]    findAll()
 * @method Penalisation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PenalisationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Penalisation::class);
    }

    // /**
    //  * @return Penalisation[] Returns an array of Penalisation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Penalisation
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
