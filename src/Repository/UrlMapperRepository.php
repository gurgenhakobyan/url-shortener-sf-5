<?php

namespace App\Repository;

use App\Entity\UrlMapper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UrlMapper|null find($id, $lockMode = null, $lockVersion = null)
 * @method UrlMapper|null findOneBy(array $criteria, array $orderBy = null)
 * @method UrlMapper[]    findAll()
 * @method UrlMapper[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UrlMapperRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UrlMapper::class);
    }

    // /**
    //  * @return UrlMapper[] Returns an array of UrlMapper objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UrlMapper
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
