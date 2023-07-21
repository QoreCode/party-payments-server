<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

//#[ApiResource(
//    operations: [
//        new GetCollection(),
//        new Get(),
//        new Post(),
//        new Put()
//    ]
//)]
#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{

    #[ORM\Id]
    #[ORM\Column(length: 255)]
    private ?string $uid = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\OneToMany(mappedBy: 'eventUid', targetEntity: UserEvent::class, orphanRemoval: true)]
    #[ORM\JoinColumn(name: 'userUid', referencedColumnName: 'eventUid')]
    private Collection $userEvents;

    #[ORM\OneToMany(mappedBy: 'eventUid', targetEntity: Payment::class, orphanRemoval: true)]
    private Collection $payments;

    public function __construct()
    {
        $this->userEvents = new ArrayCollection();
        $this->payments = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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
     * @return Collection<int, UserEvent>
     */
    public function getUserEvents(): Collection
    {
        return $this->userEvents;
    }

    public function addUserEvent(UserEvent $userEvent): static
    {
        if (!$this->userEvents->contains($userEvent)) {
            $this->userEvents->add($userEvent);
            $userEvent->setEventUid($this);
        }

        return $this;
    }

    public function removeUserEvent(UserEvent $userEvent): static
    {
        if ($this->userEvents->removeElement($userEvent)) {
            // set the owning side to null (unless already changed)
            if ($userEvent->getEventUid() === $this) {
                $userEvent->setEventUid(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Payment>
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): static
    {
        if (!$this->payments->contains($payment)) {
            $this->payments->add($payment);
            $payment->setEventUid($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): static
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getEventUid() === $this) {
                $payment->setEventUid(null);
            }
        }

        return $this;
    }
}
