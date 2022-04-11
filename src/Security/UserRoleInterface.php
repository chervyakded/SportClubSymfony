<?php

namespace EfTech\SportClub\Security;

/**
 * Роли пользователей
 */
interface UserRoleInterface
{
    /**
     * Роль - аутентифицированный пользователь
     */
    public const ROLE_AUTH_USER = 'ROLE_AUTH_USER';
}