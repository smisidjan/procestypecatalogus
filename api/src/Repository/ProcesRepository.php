<?php

namespace App\Repository;

use App\Entity\Proces;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Proces|null find($id, $lockMode = null, $lockVersion = null)
 * @method Proces|null findOneBy(array $criteria, array $orderBy = null)
 * @method Proces[]    findAll()
 * @method Proces[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProcesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Proces::class);
    }

    // /**
    //  * @return Proces[] Returns an array of Proces objects
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
    public function findOneBySomeField($value): ?Proces
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
