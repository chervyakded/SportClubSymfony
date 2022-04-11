<?php

namespace EfTech\SportClub\Entity;

interface PassRepositoryInterface
{


    /**
     * Поиск сущностей по заданным критериям
     *
     * @param  array $criteria
     * @return Pass[]
     */
    public function findBy(array $criteria): array;


}//end interface
