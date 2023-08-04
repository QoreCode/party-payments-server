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

}
