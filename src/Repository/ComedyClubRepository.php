<?php

namespace App\Repository;

use App\Entity\ComedyClub;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ComedyClub>
 *
 * @method ComedyClub|null find($id, $lockMode = null, $lockVersion = null)
 * @method ComedyClub|null findOneBy(array $criteria, array $orderBy = null)
 * @method ComedyClub[]    findAll()
 * @method ComedyClub[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComedyClubRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComedyClub::class);
    }

    //    /**
    //     * @return ComedyClub[] Returns an array of ComedyClub objects
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

    //    public function findOneBySomeField($value): ?ComedyClub
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
