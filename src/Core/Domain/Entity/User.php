<?php

namespace App\Core\Domain\Entity;

use App\User\Infrastructure\Repository\UserRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'user')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private Uuid $id;

    #[ORM\Column]
    private bool $active;

    #[ORM\Column]
    private bool $banned;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private DateTimeInterface $dateCreate;

    #[ORM\Column(length: 255)]
    private string $password;

    #[ORM\Column(length: 255)]
    private string $username;

    public function __construct(bool $active, bool $banned, DateTimeInterface $dateCreate, string $password, string $username)
    {
        $this->active = $active;
        $this->banned = $banned;
        $this->dateCreate = $dateCreate;
        $this->password = $password;
        $this->username = $username;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function isBanned(): bool
    {
        return $this->banned;
    }

    public function setBanned(bool $banned): static
    {
        $this->banned = $banned;

        return $this;
    }

    public function getDateCreate(): DateTimeInterface
    {
        return $this->dateCreate;
    }

    public function setDateCreate(DateTimeInterface $dateCreate): static
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
//        $roles = $this->roles;
//
//        $roles[] = 'ROLE_USER';
//
//        return array_unique($roles);
        return [];
    }

    public function getSalt()
    {
    }

    public function eraseCredentials()
    {
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
    }
}
