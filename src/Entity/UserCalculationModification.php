<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\UserCalculationModificationRepository;
use Doctrine\ORM\Mapping as ORM;
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put()
    ]
)]
#[ORM\Entity(repositoryClass: UserCalculationModificationRepository::class)]
class UserCalculationModification
{
    #[ORM\Id]
    #[ORM\Column(length: 255)]
    private ?string $uid = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(referencedColumnName: 'uid', nullable: false)]
    private ?User $userUid = null;

    #[ORM\ManyToOne(inversedBy: 'userCalculationModifications')]
    #[ORM\JoinColumn(referencedColumnName: 'uid', nullable: false)]
    private ?CalculationModification $calculationModificationUid = null;

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

    public function getUserUid(): ?User
    {
        return $this->userUid;
    }

    public function setUserUid(?User $userUid): static
    {
        $this->userUid = $userUid;

        return $this;
    }

    public function getCalculationModificationUid(): ?CalculationModification
    {
        return $this->calculationModificationUid;
    }

    public function setCalculationModificationUid(?CalculationModification $calculationModificationUid): static
    {
        $this->calculationModificationUid = $calculationModificationUid;

        return $this;
    }

}
