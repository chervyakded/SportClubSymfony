<?php

namespace EfTech\SportClub\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use EfTech\SportClub\Entity\Customer;
use EfTech\SportClub\Entity\PurchasedItem;
use EfTech\SportClub\Entity\CustomerRepositoryInterface;

class CustomerDoctrineRepository extends EntityRepository implements CustomerRepositoryInterface
{
    /**
     * Переопределили метод
     * @inheritDoc
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null): array
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select(['c'])
            ->from(Customer::class, 'c')
            ->innerJoin('c.pass', 'p')
            ->innerJoin('p.purchasedItems', 'pi');
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
                $whereExprAnd->add($queryBuilder->expr()->eq("pi.$criteriaName", ":$criteriaName"));
            }
        }
        $queryBuilder->where($whereExprAnd);
        $queryBuilder->setParameters($criteria);
    }
}