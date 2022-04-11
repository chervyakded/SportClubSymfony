<?php

namespace EfTech\SportClub\Entity;

interface UserRepositoryInterface
{


    /**
     * Поиск сущностей по заданному критерию
     *
     * @param  array $criteria
     * @return User[]
     */
    public function findBy(array $criteria): array;


    /**
     * Поиск пользователя по логину
     *
     * @param  string $login - Логин пользователя
     * @return User|null - Сущность пользователя
     */
    public function findUserByLogin(string $login): ?User;


}//end interface
