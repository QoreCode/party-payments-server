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
use ApiPlatform\OpenApi\Serializer\OpenApiNormalizer;
use App\Repository\CalculationModificationRepository;
use App\Validator\Constraints\CalculationModificationMember;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Delete(),
    ],
    formats: [OpenApiNormalizer::FORMAT],
    collectDenormalizationErrors: true
)]
#[ApiFilter(filterClass: SearchFilter::class, properties: ['payment'])]
#[ORM\Entity(repositoryClass: CalculationModificationRepository::class)]
class CalculationModification
{
    #[ORM\Id]
    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank]
    private string $uid;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'payment_uid', referencedColumnName: 'uid', nullable: false, onDelete: "CASCADE")]
    #[Assert\NotBlank]
    private Payment $payment;

    #[ORM\Column(type: Types::INTEGER)]
    #[Assert\NotBlank]
    private string $expression;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;

    #[ORM\JoinTable(name: 'member_calculation_modification')]
    #[ORM\JoinColumn(name: 'calculation_modification_uid', referencedColumnName: 'uid', nullable: false, onDelete: "CASCADE")]
    #[ORM\InverseJoinColumn(name: 'member_uid', referencedColumnName: 'uid',  onDelete: "CASCADE")]
    #[ORM\ManyToMany(targetEntity: Member::class)]
    #[Assert\NotNull]
    #[CalculationModificationMember]
    private Collection $members;


    public function __construct($uid, $payment)
    {
        $this->uid = $uid;
        $this->members = new ArrayCollection();
        $this->payment = $payment;
    }

    public function getUid(): string
    {
        return $this->uid;
    }

    public function getPayment(): Payment
    {
        return $this->payment;
    }

    public function getExpression(): string
    {
        return $this->expression;
    }

    public function setExpression(string $expression): static
    {
        $this->expression = $expression;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return Collection<int, Member>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Member $member): static
    {
        if (!$this->members->contains($member)) {
            $this->members->add($member);
        }

        return $this;
    }

    public function removeMember(Member $member): static
    {
        $this->members->removeElement($member);

        return $this;
    }
}
