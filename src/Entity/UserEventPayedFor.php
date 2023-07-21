<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\UserEventPayedForRepository;
use Doctrine\ORM\Mapping as ORM;
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put()
    ]
)]
#[ORM\Entity(repositoryClass: UserEventPayedForRepository::class)]
class UserEventPayedFor
{
    #[ORM\Id]
    #[ORM\Column(length: 255)]
    private ?string $uid = null;

    #[ORM\ManyToOne(inversedBy: 'userEventPayedFors')]
    #[ORM\JoinColumn(referencedColumnName: 'uid', nullable: false)]
    private ?UserEvent $userEventUid = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(referencedColumnName: 'uid', nullable: false)]
    private ?User $payedForUserUid = null;

    public function getId(): ?int
    {
        return $this->uid;
    }

    public function getUid(): ?string
    {
        return $this->uid;
    }

    public function setUid(string $uid): static
    {
        $this->uid = $uid;

        return $this;
    }

    public function getUserEventUid(): ?UserEvent
    {
        return $this->userEventUid;
    }

    public function setUserEventUid(?UserEvent $userEventUid): static
    {
        $this->userEventUid = $userEventUid;

        return $this;
    }

    public function getPayedForUserUid(): ?User
    {
        return $this->payedForUserUid;
    }

    public function setPayedForUserUid(?User $payedForUserUid): static
    {
        $this->payedForUserUid = $payedForUserUid;

        return $this;
    }
}
