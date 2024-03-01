<?php

namespace App\Repository;

use App\Entity\LogoWhite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LogoWhite>
 *
 * @method LogoWhite|null find($id, $lockMode = null, $lockVersion = null)
 * @method LogoWhite|null findOneBy(array $criteria, array $orderBy = null)
 * @method LogoWhite[]    findAll()
 * @method LogoWhite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogoWhiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LogoWhite::class);
    }

//    /**
//     * @return LogoWhite[] Returns an array of LogoWhite objects
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

//    public function findOneBySomeField($value): ?LogoWhite
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
