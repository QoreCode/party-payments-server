<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\MemberRepository;
use App\Validator\Constraints\EventMember;
use App\Validator\Constraints\MemberAndPayerSameEvent;
use App\Validator\Constraints\MemberIsNotPayer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(
            denormalizationContext: ['groups' => 'member:create'],
            validationContext: ['groups' => 'member:create']
        ),
        new Put(
            denormalizationContext: ['groups' => 'member:update'],
        ),
        new Delete(),
    ],
    formats: ['json'],
    normalizationContext: ['groups' => 'member:read'],
    denormalizationContext: [
        'groups' => [
            'member:create',
            'member:update'
        ]
    ],
    collectDenormalizationErrors: true
)]
#[ApiFilter(filterClass: SearchFilter::class, properties: ['user', 'event', 'payer'])]
#[ORM\Entity(repositoryClass: MemberRepository::class)]
#[ORM\UniqueConstraint(columns: ['user_uid', 'event_uid'])]
class Member
{
    #[ORM\Id]
    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank]
    #[Groups(['member:create', 'member:read'])]
    private string $uid;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'user_uid', referencedColumnName: 'uid', nullable: false, onDelete: "CASCADE")]
    #[Assert\NotBlank]
    #[Groups(['member:create', 'member:read'])]
    private User $user;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'event_uid', referencedColumnName: 'uid', nullable: false, onDelete: "CASCADE")]
    #[Assert\NotBlank]
    #[Groups(['member:create', 'member:read'])]
    private PartyEvent $event;

    #[ORM\ManyToOne(targetEntity: Member::class, inversedBy: 'payedFor')]
    #[ORM\JoinColumn(name: 'payer_uid', referencedColumnName: 'uid', onDelete: "set null")]
    #[EventMember]
    private ?Member $payer = null;

    #[ORM\OneToMany(mappedBy: 'payer', targetEntity: Member::class, fetch: 'EAGER')]
    #[Groups(['member:create', 'member:update', 'member:read'])]
    #[MemberIsNotPayer]
    #[MemberAndPayerSameEvent]
    private Collection $payedFor;

    public function __construct($uid, $event, $user)
    {
        $this->uid = $uid;
        $this->event = $event;
        $this->user = $user;
        $this->payedFor = new ArrayCollection();
    }

    public function getUid(): string
    {
        return $this->uid;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getEvent(): PartyEvent
    {
        return $this->event;
    }

    /**
     * @return Member|null
     */
    public function getPayer(): ?Member
    {
        return $this->payer;
    }

    /**
     * @param Member|null $payer
     */
    private function setPayer(?Member $payer): void
    {
        $this->payer = $payer;
    }

    /**
     * @param array $payedFor
     * @return Member
     */
    public function setPayedFor(array $payedFor): Member
    {
        $payedForUids = [];
        /** @var Member $member */
        foreach ($payedFor as $member) {
            $payedForUids[] = $member->getUid();
            if (!$this->payedFor->contains($member)) {
                $this->payedFor->add($member);
                $member->setPayer($this);
            }
        }
        foreach ($this->payedFor as $member) {
            if (!in_array($member->getUid(), $payedForUids)
                && $this->payedFor->removeElement($member)
                && $member->getPayer() === $this
            ) {
                $member->setPayer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getPayedFor(): Collection
    {
        return $this->payedFor;
    }
}
