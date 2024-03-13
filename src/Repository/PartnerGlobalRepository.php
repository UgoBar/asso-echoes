<?php

namespace App\Repository;

use App\Entity\PartnerGlobal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PartnerGlobal>
 *
 * @method PartnerGlobal|null find($id, $lockMode = null, $lockVersion = null)
 * @method PartnerGlobal|null findOneBy(array $criteria, array $orderBy = null)
 * @method PartnerGlobal[]    findAll()
 * @method PartnerGlobal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartnerGlobalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PartnerGlobal::class);
    }

//    /**
//     * @return PartnerGlobal[] Returns an array of PartnerGlobal objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PartnerGlobal
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
