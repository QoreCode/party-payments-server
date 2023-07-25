<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\UserCalculationModificationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Delete(),
    ]
)]
#[ORM\Entity(repositoryClass: UserCalculationModificationRepository::class)]
class UserCalculationModification
{
    #[ORM\Id]
    #[ORM\Column(length: 255, unique: true)]
    private string $uid;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'user_uid', referencedColumnName: 'uid', nullable: false)]
    private ?User $userUid;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'calculation_modification_uid', referencedColumnName: 'uid', nullable: false)]
    private ?CalculationModification $calculationModificationUid;

    public function getUid(): string
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
