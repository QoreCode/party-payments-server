<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\OpenApi\Serializer\OpenApiNormalizer;
use App\Repository\PaymentRepository;
use App\Validator\Constraints\EventMember;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(
            denormalizationContext: ['groups' => 'payment:create'],
        ),
        new Put(
            denormalizationContext: ['groups' => 'payment:update']
        ),
        new Delete()
    ],
    formats: [OpenApiNormalizer::FORMAT],
    denormalizationContext: [
        'groups' => [
            'payment:create',
            'payment:update'
        ]
    ],
    collectDenormalizationErrors: true
)]
#[ApiFilter(filterClass: SearchFilter::class, properties: ['event', 'member', 'name' => 'partial'])]
#[ApiFilter(filterClass: RangeFilter::class, properties: ['date'])]
#[ApiFilter(filterClass: OrderFilter::class, properties: ['date' => 'ASC', 'name' => 'ASC'])]
#[ORM\Entity(repositoryClass: PaymentRepository::class)]
class Payment
{
    #[ORM\Id]
    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank]
    #[Groups(['payment:create'])]
    private string $uid;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'event_uid', referencedColumnName: 'uid', nullable: false, onDelete: "CASCADE")]
    #[Assert\NotBlank]
    #[Groups(['payment:create'])]
    private PartyEvent $event;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'payer_uid', referencedColumnName: 'uid', nullable: false, onDelete: "CASCADE")]
    #[Groups(['payment:create', 'payment:update'])]
    #[Assert\NotBlank]
    #[EventMember]
    private Member $payer;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['payment:create', 'payment:update'])]
    private string $name;

    #[ORM\Column(type: Types::INTEGER)]
    #[Assert\GreaterThanOrEqual(0)]
    #[Groups(['payment:create', 'payment:update'])]
    private int $amount;

    #[ORM\Column(type: Types::BIGINT)]
    #[Groups(['payment:create'])]
    private string $date;

    public function __construct($uid, $event, $date = null)
    {
        $this->uid = $uid;
        $this->event = $event;
        $this->date = $date ?? time();
    }

    public function getUid(): string
    {
        return $this->uid;
    }

    public function getEvent(): PartyEvent
    {
        return $this->event;
    }

    public function getPayer(): Member
    {
        return $this->payer;
    }

    public function setPayer(Member $payer): static
    {
        $this->payer = $payer;

        return $this;
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

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): static
    {
        $this->amount = $amount;

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
}
