<?php

namespace App\Repository;

use App\Entity\Worksheets;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Worksheets|null find($id, $lockMode = null, $lockVersion = null)
 * @method Worksheets|null findOneBy(array $criteria, array $orderBy = null)
 * @method Worksheets[]    findAll()
 * @method Worksheets[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorksheetsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Worksheets::class);
    }

    // /**
    //  * @return Worksheets[] Returns an array of Worksheets objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Worksheets
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
