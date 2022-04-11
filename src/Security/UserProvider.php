<?php

namespace EfTech\SportClub\Security;

use Doctrine\ORM\EntityManagerInterface;
use EfTech\SportClub\Entity\UserRepositoryInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class UserProvider implements UserProviderInterface
{
    /**
     * Сервис поиска пользователей
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * Менеджер сущностей
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @param UserRepositoryInterface $userRepository
     * @param EntityManagerInterface  $em
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        EntityManagerInterface  $em
    ) {
        $this->userRepository = $userRepository;
        $this->em             = $em;
    }

    /**
     * @inheritDoc
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        $userFromDomain = $this->userRepository->findUserByLogin($user->getUserIdentifier());
        $this->em->refresh($userFromDomain);
        return $user;
    }

    /**
     * @inheritDoc
     */
    public function supportsClass(string $class): bool
    {
        return $class === User::class;
    }

    /**
     * @inheritDoc
     * @return UserInterface
     */
    public function loadUserByUsername(string $username)
    {
        return $this->loadUserByIdentifier($username);
    }

    /**
     * @inheritDoc
     */
    public function loadUserByIdentifier(string $identifier): User
    {
        $userFromDomain = $this->userRepository->findUserByLogin($identifier);
        if (null === $userFromDomain) {
            throw new UserNotFoundException("Пользователь '$identifier' не найден");
        }
        return new User($userFromDomain);
    }
}