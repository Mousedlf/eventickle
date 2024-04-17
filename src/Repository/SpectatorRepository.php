<?php

namespace App\Repository;

use App\Entity\Spectator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Spectator>
 *
 * @method Spectator|null find($id, $lockMode = null, $lockVersion = null)
 * @method Spectator|null findOneBy(array $criteria, array $orderBy = null)
 * @method Spectator[]    findAll()
 * @method Spectator[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpectatorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Spectator::class);
    }

    //    /**
    //     * @return Spectator[] Returns an array of Spectator objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Spectator
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
