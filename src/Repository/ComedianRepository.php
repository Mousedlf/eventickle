<?php

namespace App\Repository;

use App\Entity\Comedian;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comedian>
 *
 * @method Comedian|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comedian|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comedian[]    findAll()
 * @method Comedian[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComedianRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comedian::class);
    }

    //    /**
    //     * @return Comedian[] Returns an array of Comedian objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Comedian
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
