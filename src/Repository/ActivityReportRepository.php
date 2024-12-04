<?php

namespace App\Repository;

use App\Entity\ActivityReport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ActivityReport>
 *
 * @method ActivityReport|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActivityReport|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActivityReport[]    findAll()
 * @method ActivityReport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivityReportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActivityReport::class);
    }

//    /**
//     * @return ActivityReport[] Returns an array of ActivityReport objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ActivityReport
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
