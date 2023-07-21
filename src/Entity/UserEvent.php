<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\UserEventRepository;
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
#[ORM\Entity(repositoryClass: UserEventRepository::class)]
class UserEvent
{
    #[ORM\Id]
    #[ORM\Column(length: 255)]
    private ?string $uid = null;

    #[ORM\ManyToOne(inversedBy: 'userEvents')]
    #[ORM\JoinColumn(referencedColumnName: 'uid', nullable: false)]
    private ?Event $eventUid = null;

    #[ORM\ManyToOne(inversedBy: 'userEvents')]
    #[ORM\JoinColumn(referencedColumnName: 'uid', nullable: false)]
    private ?User $userUid = null;

    #[ORM\OneToMany(mappedBy: 'userEventUid', targetEntity: UserEventPayedFor::class, orphanRemoval: true)]
    private Collection $userEventPayedFors;

    public function __construct()
    {
        $this->userEventPayedFors = new ArrayCollection();
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

    /**
     * @return Collection<int, UserEventPayedFor>
     */
    public function getUserEventPayedFors(): Collection
    {
        return $this->userEventPayedFors;
    }

    public function addUserEventPayedFor(UserEventPayedFor $userEventPayedFor): static
    {
        if (!$this->userEventPayedFors->contains($userEventPayedFor)) {
            $this->userEventPayedFors->add($userEventPayedFor);
            $userEventPayedFor->setUserEventUid($this);
        }

        return $this;
    }

    public function removeUserEventPayedFor(UserEventPayedFor $userEventPayedFor): static
    {
        if ($this->userEventPayedFors->removeElement($userEventPayedFor)) {
            // set the owning side to null (unless already changed)
            if ($userEventPayedFor->getUserEventUid() === $this) {
                $userEventPayedFor->setUserEventUid(null);
            }
        }

        return $this;
    }
}
