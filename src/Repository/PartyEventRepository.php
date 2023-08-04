<?php

namespace App\Repository;

use App\Entity\PartyEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PartyEvent>
 *
 * @method PartyEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method PartyEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method PartyEvent[]    findAll()
 * @method PartyEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartyEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PartyEvent::class);
    }

}
