<?php

namespace App\Repository;

use App\Entity\MusicSession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MusicSession>
 *
 * @method MusicSession|null find($id, $lockMode = null, $lockVersion = null)
 * @method MusicSession|null findOneBy(array $criteria, array $orderBy = null)
 * @method MusicSession[]    findAll()
 * @method MusicSession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MusicSessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MusicSession::class);
    }

//    /**
//     * @return MusicSession[] Returns an array of MusicSession objects
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

//    public function findOneBySomeField($value): ?MusicSession
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
