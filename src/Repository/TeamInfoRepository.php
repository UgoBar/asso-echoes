<?php

namespace App\Repository;

use App\Entity\TeamInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TeamInfo>
 *
 * @method TeamInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method TeamInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method TeamInfo[]    findAll()
 * @method TeamInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TeamInfo::class);
    }

//    /**
//     * @return TeamInfo[] Returns an array of TeamInfo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TeamInfo
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
