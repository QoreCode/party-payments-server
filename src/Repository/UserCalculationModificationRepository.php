<?php

namespace App\Repository;

use App\Entity\UserCalculationModification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserCalculationModification>
 *
 * @method UserCalculationModification|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserCalculationModification|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserCalculationModification[]    findAll()
 * @method UserCalculationModification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserCalculationModificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserCalculationModification::class);
    }

//    /**
//     * @return UserCalculationModification[] Returns an array of UserCalculationModification objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UserCalculationModification
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
