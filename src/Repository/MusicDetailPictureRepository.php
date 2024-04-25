<?php

namespace App\Repository;

use App\Entity\MusicDetailPicture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MusicDetailPicture>
 *
 * @method MusicDetailPicture|null find($id, $lockMode = null, $lockVersion = null)
 * @method MusicDetailPicture|null findOneBy(array $criteria, array $orderBy = null)
 * @method MusicDetailPicture[]    findAll()
 * @method MusicDetailPicture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MusicDetailPictureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MusicDetailPicture::class);
    }

//    /**
//     * @return MusicDetailPicture[] Returns an array of MusicDetailPicture objects
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

//    public function findOneBySomeField($value): ?MusicDetailPicture
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
