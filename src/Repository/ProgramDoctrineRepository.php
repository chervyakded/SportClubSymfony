<?php

namespace EfTech\SportClub\Repository;

use Doctrine\ORM\EntityRepository;
use EfTech\SportClub\Entity\Programme;
use EfTech\SportClub\Entity\ProgramRepositoryInterface;

class ProgramDoctrineRepository extends EntityRepository implements ProgramRepositoryInterface
{
    /**
     * Переопределили метод
     * @inheritDoc
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null): array
    {
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }

    public function nextId(): int
    {
        return $this->getClassMetadata()->idGenerator->generateId($this->getEntityManager(), null);
    }

    public function add(Programme $entity): Programme
    {
        $this->getEntityManager()->persist($entity);
        return $entity;
    }
}