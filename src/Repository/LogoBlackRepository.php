<?php

namespace App\Repository;

use App\Entity\LogoBlack;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LogoBlack>
 *
 * @method LogoBlack|null find($id, $lockMode = null, $lockVersion = null)
 * @method LogoBlack|null findOneBy(array $criteria, array $orderBy = null)
 * @method LogoBlack[]    findAll()
 * @method LogoBlack[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogoBlackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LogoBlack::class);
    }

//    /**
//     * @return LogoBlack[] Returns an array of LogoBlack objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LogoBlack
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
