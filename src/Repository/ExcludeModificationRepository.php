<?php

namespace App\Repository;

use App\Entity\ExcludeModification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExcludeModification>
 *
 * @method ExcludeModification|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExcludeModification|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExcludeModification[]    findAll()
 * @method ExcludeModification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExcludeModificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExcludeModification::class);
    }

//    /**
//     * @return ExcludeModification[] Returns an array of ExcludeModification objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ExcludeModification
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
