<?php

namespace App\Repository;

use App\Entity\Radiobox;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Radiobox>
 *
 * @method Radiobox|null find($id, $lockMode = null, $lockVersion = null)
 * @method Radiobox|null findOneBy(array $criteria, array $orderBy = null)
 * @method Radiobox[]    findAll()
 * @method Radiobox[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RadioboxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Radiobox::class);
    }

//    /**
//     * @return Radiobox[] Returns an array of Radiobox objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Radiobox
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
