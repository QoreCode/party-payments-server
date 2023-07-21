<?php

namespace App\Repository;

use App\Entity\UserEventPayedFor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserEventPayedFor>
 *
 * @method UserEventPayedFor|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserEventPayedFor|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserEventPayedFor[]    findAll()
 * @method UserEventPayedFor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserEventPayedForRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserEventPayedFor::class);
    }

//    /**
//     * @return UserEventPayedFor[] Returns an array of UserEventPayedFor objects
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

//    public function findOneBySomeField($value): ?UserEventPayedFor
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
