<?php

namespace App\Repository;

use App\Entity\CalculationModification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CalculationModification>
 *
 * @method CalculationModification|null find($id, $lockMode = null, $lockVersion = null)
 * @method CalculationModification|null findOneBy(array $criteria, array $orderBy = null)
 * @method CalculationModification[]    findAll()
 * @method CalculationModification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CalculationModificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CalculationModification::class);
    }

//    /**
//     * @return CalculationModification[] Returns an array of CalculationModification objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CalculationModification
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
