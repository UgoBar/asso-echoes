<?php

namespace App\Repository;

use App\Entity\MusicDetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MusicDetail>
 *
 * @method MusicDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method MusicDetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method MusicDetail[]    findAll()
 * @method MusicDetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MusicDetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MusicDetail::class);
    }

//    /**
//     * @return MusicDetail[] Returns an array of MusicDetail objects
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

//    public function findOneBySomeField($value): ?MusicDetail
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
