<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\MemberPayedForRepository;
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
#[ORM\Entity(repositoryClass: MemberPayedForRepository::class)]
class MemberPayedFor
{

    #[ORM\Id]
    #[ORM\Column(length: 255, unique: true)]
    private string $uid;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'member_uid', referencedColumnName: 'uid', nullable: false)]
    private PartyEventMember $memberUid;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'payed_for_user_uid', referencedColumnName: 'uid', nullable: false)]
    private User $payedForUserUid;

    public function getUid(): string
    {
        return $this->uid;
    }

    public function setUid(string $uid): static
    {
        $this->uid = $uid;

        return $this;
    }

    public function getMemberUid(): ?PartyEventMember
    {
        return $this->memberUid;
    }

    public function setMemberUid(?PartyEventMember $memberUid): static
    {
        $this->memberUid = $memberUid;

        return $this;
    }

    public function getPayedForuserUid(): ?User
    {
        return $this->payedForuserUid;
    }

    public function setPayedForuserUid(?User $payedForuserUid): static
    {
        $this->payedForuserUid = $payedForuserUid;

        return $this;
    }
}
