<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
    ],
    formats: ['json'],
    collectDenormalizationErrors: true
)]
#[ApiFilter(filterClass: SearchFilter::class, properties: ['name' => 'partial', 'isActive' => 'exact'])]
#[ApiFilter(OrderFilter::class, properties: ['name' => 'ASC', 'isActive' => 'ASC'])]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\Column(length: 255, unique: true)]
    #[NotBlank]
    private string $uid;

    #[ORM\Column(length: 255)]
    #[NotBlank]
    private string $name;

    #[ORM\Column(length: 20, nullable: true)]
    #[Assert\CardScheme(schemes: [Assert\CardScheme::VISA, Assert\CardScheme::MASTERCARD])]
    private ?string $creditCardNumber = null;

    #[ORM\Column]
    private bool $isActive = true;

    public function __construct($uid)
    {
        $this->uid = $uid;
    }

    public function getUid(): string
    {
        return $this->uid;
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

    public function getCreditCardNumber(): ?string
    {
        return $this->creditCardNumber;
    }

    public function setCreditCardNumber(?string $creditCardNumber): static
    {
        $this->creditCardNumber = $creditCardNumber;

        return $this;
    }

    public function isIsActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }


}
