<?php

namespace EfTech\SportClub\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use EfTech\SportClub\Entity\BenefitPass;
use EfTech\SportClub\Entity\BenefitPassRepositoryInterface;

class BenefitPassDoctrineRepository extends EntityRepository implements BenefitPassRepositoryInterface
{
    /**
     * Переопределили метод
     * @inheritDoc
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null): array
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select(['b'])
            ->from(BenefitPass::class, 'b')
            ->leftJoin('b.customer', 'c');
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
            if (0 === strpos($criteriaName, 'customer_')) {
                $preparedCriteriaName = substr($criteriaName, 9);
                $whereExprAnd->add($queryBuilder->expr()->eq("c.$preparedCriteriaName", ":$criteriaName"));
            } else {
                $whereExprAnd->add($queryBuilder->expr()->eq("b.$criteriaName", ":$criteriaName"));
            }
        }
        $queryBuilder->where($whereExprAnd);
        $queryBuilder->setParameters($criteria);
    }
}