<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
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
        new GetCollection(),
        new Get(),
        new Post(),
        new Put()
    ]
)]
#[ORM\Entity(repositoryClass: PaymentRepository::class)]
class Payment
{
    #[ORM\Id]
    #[ORM\Column(length: 255)]
    private ?string $uid = null;

    #[ORM\ManyToOne(inversedBy: 'payments')]
    #[ORM\JoinColumn(referencedColumnName: 'uid',nullable: false)]
    private ?Event $eventUid = null;

    #[ORM\ManyToOne(inversedBy: 'payments')]
    #[ORM\JoinColumn(referencedColumnName: 'uid',nullable: false)]
    private ?User $userUid = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?string $money = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\OneToMany(mappedBy: 'paymentUid', targetEntity: CalculationModification::class, orphanRemoval: true)]
    private Collection $calculationModifications;

    #[ORM\OneToMany(mappedBy: 'paymentUid', targetEntity: ExcludeUserModification::class, orphanRemoval: true)]
    private Collection $excludeUserModifications;

    public function __construct()
    {
        $this->calculationModifications = new ArrayCollection();
        $this->excludeUserModifications = new ArrayCollection();
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

    public function getEventUid(): ?Event
    {
        return $this->eventUid;
    }

    public function setEventUid(?Event $eventUid): static
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getMoney(): ?string
    {
        return $this->money;
    }

    public function setMoney(string $money): static
    {
        $this->money = $money;

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
     * @return Collection<int, ExcludeUserModification>
     */
    public function getExcludeUserModifications(): Collection
    {
        return $this->excludeUserModifications;
    }

    public function addExcludeUserModification(ExcludeUserModification $excludeUserModification): static
    {
        if (!$this->excludeUserModifications->contains($excludeUserModification)) {
            $this->excludeUserModifications->add($excludeUserModification);
            $excludeUserModification->setPaymentUid($this);
        }

        return $this;
    }

    public function removeExcludeUserModification(ExcludeUserModification $excludeUserModification): static
    {
        if ($this->excludeUserModifications->removeElement($excludeUserModification)) {
            // set the owning side to null (unless already changed)
            if ($excludeUserModification->getPaymentUid() === $this) {
                $excludeUserModification->setPaymentUid(null);
            }
        }

        return $this;
    }
}
