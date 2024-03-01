<?php

namespace App\Repository;

use App\Entity\Organize;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Organize>
 *
 * @method Organize|null find($id, $lockMode = null, $lockVersion = null)
 * @method Organize|null findOneBy(array $criteria, array $orderBy = null)
 * @method Organize[]    findAll()
 * @method Organize[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrganizeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Organize::class);
    }

//    /**
//     * @return Organize[] Returns an array of Organize objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Organize
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
