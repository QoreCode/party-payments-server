<?php

namespace App\Repository;

use App\Entity\MemberPayedFor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MemberPayedFor>
 *
 * @method MemberPayedFor|null find($id, $lockMode = null, $lockVersion = null)
 * @method MemberPayedFor|null findOneBy(array $criteria, array $orderBy = null)
 * @method MemberPayedFor[]    findAll()
 * @method MemberPayedFor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemberPayedForRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MemberPayedFor::class);
    }

//    /**
//     * @return MemberPayedFor[] Returns an array of MemberPayedFor objects
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

//    public function findOneBySomeField($value): ?MemberPayedFor
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
