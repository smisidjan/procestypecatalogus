<?php

namespace App\Repository;

use App\Entity\ProcessType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProcessType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProcessType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProcessType[]    findAll()
 * @method ProcessType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProcessTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
    	parent::__construct($registry, ProcessType::class);
    }

    // /**
    //  * @return Process[] Returns an array of Proces objects
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
