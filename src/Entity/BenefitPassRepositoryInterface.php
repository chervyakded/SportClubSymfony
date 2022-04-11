<?php

namespace EfTech\SportClub\Entity;

interface BenefitPassRepositoryInterface
{


    /**
     * Поиск сущностей по заданным критериям
     *
     * @param  array $criteria
     * @return BenefitPass[]
     */
    public function findBy(array $criteria): array;


}//end interface
