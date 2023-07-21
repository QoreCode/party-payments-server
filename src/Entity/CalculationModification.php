<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\CalculationModificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put()
    ]
)]
#[ORM\Entity(repositoryClass: CalculationModificationRepository::class)]
class CalculationModification
{

    #[ORM\Id]
    #[ORM\Column(length: 255)]
    private ?string $uid = null;

    #[ORM\ManyToOne(inversedBy: 'calculationModifications')]
    #[ORM\JoinColumn(referencedColumnName: 'uid',nullable: false)]
    private ?Payment $paymentUid = null;

    #[ORM\Column]
    private ?int $mathExpression = null;

    #[ORM\OneToMany(mappedBy: 'calculationModificationUid', targetEntity: UserCalculationModification::class, orphanRemoval: true)]
    private Collection $userCalculationModifications;

    public function __construct()
    {
        $this->userCalculationModifications = new ArrayCollection();
    }


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

    public function getPaymentUid(): ?Payment
    {
        return $this->paymentUid;
    }

    public function setPaymentUid(?Payment $paymentUid): static
    {
        $this->paymentUid = $paymentUid;

        return $this;
    }

    public function getMathExpression(): ?int
    {
        return $this->mathExpression;
    }

    public function setMathExpression(int $mathExpression): static
    {
        $this->mathExpression = $mathExpression;

        return $this;
    }

    /**
     * @return Collection<int, UserCalculationModification>
     */
    public function getUserCalculationModifications(): Collection
    {
        return $this->userCalculationModifications;
    }

    public function addUserCalculationModification(UserCalculationModification $userCalculationModification): static
    {
        if (!$this->userCalculationModifications->contains($userCalculationModification)) {
            $this->userCalculationModifications->add($userCalculationModification);
            $userCalculationModification->setCalculationModificationUid($this);
        }

        return $this;
    }

    public function removeUserCalculationModification(UserCalculationModification $userCalculationModification): static
    {
        if ($this->userCalculationModifications->removeElement($userCalculationModification)) {
            // set the owning side to null (unless already changed)
            if ($userCalculationModification->getCalculationModificationUid() === $this) {
                $userCalculationModification->setCalculationModificationUid(null);
            }
        }

        return $this;
    }
}
