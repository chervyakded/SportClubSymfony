<?php

namespace EfTech\SportClub\Security;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use EfTech\SportClub\Entity\User as UserFormDomain;

final class User implements PasswordAuthenticatedUserInterface, UserInterface
{
    /**
     * Пользователь из приложения
     * @var UserFormDomain
     */
    private UserFormDomain $user;

    /**
     * @param UserFormDomain $user
     */
    public function __construct(UserFormDomain $user)
    {
        $this->user = $user;
    }

    /**
     * @inheritDoc
     */
    public function getPassword(): ?string
    {
        return $this->user->getPassword();
    }

    /**
     * @inheritDoc
     */
    public function getRoles(): array
    {
        return [
            UserRoleInterface::ROLE_AUTH_USER
        ];
    }

    /**
     * @inheritDoc
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials(): void
    {
    }

    /**
     * @inheritDoc
     */
    public function getUsername(): string
    {
        return $this->user->getLogin();
    }

    /**
     * @inheritDoc
     */
    public function getUserIdentifier(): string
    {
        return $this->user->getLogin();
    }
}