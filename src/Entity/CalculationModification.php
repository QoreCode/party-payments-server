<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\CalculationModificationRepository;
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
#[ORM\Entity(repositoryClass: CalculationModificationRepository::class)]
class CalculationModification
{
    #[ORM\Id]
    #[ORM\Column(length: 255, unique: true)]
    private ?string $uid;

    #[ORM\ManyToOne(inversedBy: 'calculationModifications')]
    #[ORM\JoinColumn(name: 'payment_uid', referencedColumnName: 'uid', nullable: false)]
    private ?Payment $paymentUid;

    #[ORM\Column]
    private int $mathExpression;

    public function getUid(): string
    {
        return $this->uid;
    }

    public function setUid(string $uid): static
    {
        $this->uid = $uid;

        return $this;
    }

    public function getPaymentUid(): ?Payment
    {
        return $this->paymentUid;
    }

    public function setPaymentUid(?Payment $paymentUid): static
    {
        $this->paymentUid = $paymentUid;

        return $this;
    }

    public function getMathExpression(): int
    {
        return $this->mathExpression;
    }

    public function setMathExpression(int $mathExpression): static
    {
        $this->mathExpression = $mathExpression;

        return $this;
    }
}
