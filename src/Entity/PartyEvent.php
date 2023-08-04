<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use App\Repository\PartyEventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Delete(),
    ],
    formats: ['json'],
    normalizationContext: ['groups' => 'event:read'],
    denormalizationContext: [
        'groups' => [
            'event:create',
            'event:update'
        ]
    ],
    collectDenormalizationErrors: true
)]
#[ApiFilter(filterClass: SearchFilter::class, properties: ['name' => 'partial', 'members.user'])]
#[ApiFilter(RangeFilter::class, properties: ['date'])]
#[ApiFilter(OrderFilter::class, properties: ['date' => 'ASC', 'name' => 'ASC'])]
#[ORM\Entity(repositoryClass: PartyEventRepository::class)]
class PartyEvent
{

    #[ORM\Id]
    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank]
    #[Groups(['event:read', 'event:create'])]
    private string $uid;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['event:read', 'event:create', 'event:update'])]
    private string $name;

    #[ORM\Column(type: Types::INTEGER)]
    #[Assert\NotBlank]
    #[Groups(['event:read', 'event:create'])]
    private int $date;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: Member::class)]
    private Collection $members;


    public function __construct($uid, $date = null)
    {
        $this->uid = $uid;
        $this->date = $date ?? time();
        $this->members = new ArrayCollection();
    }

    public function getUid(): string
    {
        return $this->uid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDate(): int
    {
        return $this->date;
    }

    public function setDate(int $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getMembers(): Collection
    {
        return $this->members;
    }
}
