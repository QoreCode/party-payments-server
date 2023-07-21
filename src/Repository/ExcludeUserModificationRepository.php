<?php

namespace App\Repository;

use App\Entity\ExcludeUserModification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExcludeUserModification>
 *
 * @method ExcludeUserModification|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExcludeUserModification|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExcludeUserModification[]    findAll()
 * @method ExcludeUserModification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExcludeUserModificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExcludeUserModification::class);
    }

//    /**
//     * @return ExcludeUserModification[] Returns an array of ExcludeUserModification objects
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

//    public function findOneBySomeField($value): ?ExcludeUserModification
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
