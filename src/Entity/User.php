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
use ApiPlatform\OpenApi\Serializer\OpenApiNormalizer;
use App\Repository\UserRepository;
use App\State\UserLoginProcessor;
use App\State\UserPasswordHasher;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(
            uriTemplate: '/login',
            description: 'Login Action',
            denormalizationContext: ['groups' => 'user:login'],
            validationContext: ['groups' => 'user:login'],
            processor: UserLoginProcessor::class
        ),
        new Post(
            description: 'Create User/Register Action',
            denormalizationContext: ['groups' => 'user:create'],
            validationContext: ['groups' => 'user:create'],
            processor: UserPasswordHasher::class

        ),
        new Put(
            validationContext: ['groups' => ['user:update']],
            processor: UserPasswordHasher::class
        )
    ],
    formats: [OpenApiNormalizer::FORMAT],
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: [
        'groups' => [
            'user:create',
            'user:login',
            'user:update'
        ]
    ],
    collectDenormalizationErrors: true
)]
#[ApiFilter(SearchFilter::class, properties: ['accountId', 'isActive', 'name' => 'partial', 'email' => 'partial'])]
#[ApiFilter(OrderFilter::class, properties: ['name' => 'ASC', 'isActive' => 'ASC'])]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

    #[ORM\Id]
    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[Assert\NotBlank(groups: ['user:create'])]
    private ?string $uid = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'user:create'])]
    #[Assert\NotBlank(groups: ['user:create'])]
    private string $name;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['user:read', 'user:create', 'user:update', 'user:login'])]
    #[Assert\Email(groups: ['user:create', 'user:update', 'user:login'])]
    private string $email;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column]
    private string $password;

    #[Groups(['user:create', 'user:update', 'user:login'])]
    #[Assert\PasswordStrength(
        options: ['minScore' => Assert\PasswordStrength::STRENGTH_WEAK],
        groups: ['user:create', 'user:update']
    )]
    #[Assert\NotBlank(groups: ['user:login'])]
    #[SerializedName('password')]
    private ?string $plainPassword = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $token;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Groups(['user:read'])]
    private string $accountId;

    #[ORM\Column(length: 20, nullable: true)]
    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[Assert\CardScheme(
        schemes: [Assert\CardScheme::VISA, Assert\CardScheme::MASTERCARD],
        groups: [
            'user:create',
            'user:update'
        ])]
    private ?string $creditCardNumber = null;

    #[ORM\Column]
    #[Groups(['user:read'])]
    private bool $isActive = true;

    public function __construct(?string $uid = null)
    {
        $this->uid = $uid;
        $this->token = bin2hex(random_bytes(32));
        $this->accountId = strtoupper(bin2hex(random_bytes(3)));
    }

    public function getUid(): ?string
    {
        return $this->uid;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getToken(): string
    {
        return $this->token;
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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

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

    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function getAccountId(): string
    {
        return $this->accountId;
    }
}
