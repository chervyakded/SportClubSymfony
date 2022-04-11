<?php

namespace EfTech\SportClub\Entity;

interface CustomerRepositoryInterface
{
    /**
     * Поиск сущностей по заданным критериям
     *
     * @param  array $criteria
     * @return PurchasedItem[]
     */
    public function findBy(array $criteria): array;
}
