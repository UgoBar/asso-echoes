<?php

namespace App\Repository;

use App\Entity\Memorybox;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Memorybox>
 *
 * @method Memorybox|null find($id, $lockMode = null, $lockVersion = null)
 * @method Memorybox|null findOneBy(array $criteria, array $orderBy = null)
 * @method Memorybox[]    findAll()
 * @method Memorybox[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemoryboxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Memorybox::class);
    }

//    /**
//     * @return Memorybox[] Returns an array of Memorybox objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Memorybox
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
