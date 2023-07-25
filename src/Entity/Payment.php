<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\PaymentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
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
#[ORM\Entity(repositoryClass: PaymentRepository::class)]
class Payment
{

    #[ORM\Id]
    #[ORM\Column(length: 255, unique: true)]
    private string $uid;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column]
    private int $amount;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'event_uid', referencedColumnName: 'uid', nullable: false)]
    private PartyEvent $eventUid;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'user_uid', referencedColumnName: 'uid', nullable: false)]
    private User $userUid;

    #[ORM\OneToMany(mappedBy: 'paymentUid', targetEntity: CalculationModification::class, orphanRemoval: true)]
    private Collection $calculationModifications;

    #[ORM\OneToMany(mappedBy: 'paymentUid', targetEntity: ExcludeModification::class, orphanRemoval: true)]
    private Collection $excludeModifications;

    public function __construct()
    {
        $this->calculationModifications = new ArrayCollection();
        $this->excludeModifications = new ArrayCollection();
    }

    public function getUid(): string
    {
        return $this->uid;
    }

    public function setUid(string $uid): static
    {
        $this->uid = $uid;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getEventUid(): ?PartyEvent
    {
        return $this->eventUid;
    }

    public function setEventUid(?PartyEvent $eventUid): static
    {
        $this->eventUid = $eventUid;

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

    /**
     * @return Collection<int, CalculationModification>
     */
    public function getCalculationModifications(): Collection
    {
        return $this->calculationModifications;
    }

    public function addCalculationModification(CalculationModification $calculationModification): static
    {
        if (!$this->calculationModifications->contains($calculationModification)) {
            $this->calculationModifications->add($calculationModification);
            $calculationModification->setPaymentUid($this);
        }

        return $this;
    }

    public function removeCalculationModification(CalculationModification $calculationModification): static
    {
        if ($this->calculationModifications->removeElement($calculationModification)) {
            // set the owning side to null (unless already changed)
            if ($calculationModification->getPaymentUid() === $this) {
                $calculationModification->setPaymentUid(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ExcludeModification>
     */
    public function getExcludeModifications(): Collection
    {
        return $this->excludeModifications;
    }

    public function addExcludeModification(ExcludeModification $excludeModification): static
    {
        if (!$this->excludeModifications->contains($excludeModification)) {
            $this->excludeModifications->add($excludeModification);
            $excludeModification->setPaymentUid($this);
        }

        return $this;
    }

    public function removeExcludeModification(ExcludeModification $excludeModification): static
    {
        if ($this->excludeModifications->removeElement($excludeModification)) {
            // set the owning side to null (unless already changed)
            if ($excludeModification->getPaymentUid() === $this) {
                $excludeModification->setPaymentUid(null);
            }
        }

        return $this;
    }
}
