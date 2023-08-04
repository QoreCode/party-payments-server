<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Serializer\OpenApiNormalizer;
use App\Repository\ExcludeModificationRepository;
use App\Validator\Constraints\ExcludedMember;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Delete(),
    ],
    formats: [OpenApiNormalizer::FORMAT],
    collectDenormalizationErrors: true
)]
#[ApiFilter(filterClass: SearchFilter::class, properties: ['payment', 'member'])]
#[ORM\Entity(repositoryClass: ExcludeModificationRepository::class)]
#[ORM\UniqueConstraint(columns: ['payment_uid', 'member_uid'])]
class ExcludeModification
{
    #[ORM\Id]
    #[ORM\Column(length: 255, unique: true)]
    #[NotBlank]
    private string $uid;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'payment_uid', referencedColumnName: 'uid', nullable: false, onDelete: "CASCADE")]
    #[NotBlank]
    private Payment $payment;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'member_uid', referencedColumnName: 'uid', nullable: false, onDelete: "CASCADE")]
    #[NotBlank]
    #[ExcludedMember]
    private Member $member;

    public function __construct($uid, $payment, $member)
    {
        $this->uid = $uid;
        $this->payment = $payment;
        $this->member = $member;
    }

    public function getUid(): string
    {
        return $this->uid;
    }

    public function getPayment(): Payment
    {
        return $this->payment;
    }

    public function getMember(): Member
    {
        return $this->member;
    }
}
