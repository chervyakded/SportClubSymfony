<?php

namespace EfTech\SportClub\Entity;

use JsonException;

interface ProgramRepositoryInterface
{


    /**
     * Поиск сущностей по заданным критериям
     *
     * @param  array $criteria
     * @return Programme[]
     */
    public function findBy(array $criteria): array;


    /**
     * Возвращает ID для создания следующей программы
     *
     * @return integer
     */
    public function nextId(): int;


    /**
     * Добавляет новую сущность в репозиторий
     *
     * @param  Programme $entity
     * @return Programme
     */
    public function add(Programme $entity): Programme;


}//end interface
