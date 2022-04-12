<?php

namespace EfTech\SportClub\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
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
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select(['p'])
            ->from(Programme::class, 'p');
        $this->buildWhere($queryBuilder, $criteria);
        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Формируем условия поиска в запросе на основе критериев
     *
     * @param QueryBuilder $queryBuilder
     * @param array $criteria
     * @return void
     */
    private function buildWhere(QueryBuilder $queryBuilder, array $criteria): void
    {
        if (0 === count($criteria)) {
            return;
        }
        $whereExprAnd = $queryBuilder->expr()->andX();
        foreach ($criteria as $criteriaName => $criteriaValue) {
            $whereExprAnd->add($queryBuilder->expr()->eq("p.$criteriaName", ":$criteriaName"));
        }
        $queryBuilder->where($whereExprAnd);
        $queryBuilder->setParameters($criteria);
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