<?php

namespace EfTech\SportClub\Repository;

use EfTech\SportClub\Entity\UserRepositoryInterface;
use EfTech\SportClub\Exception\RuntimeException;
use Doctrine\ORM\EntityRepository;
use EfTech\SportClub\Entity\User;

class UserDoctrineRepository extends EntityRepository implements UserRepositoryInterface
{
    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param $limit
     * @param $offset
     * @return User[]
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null): array
    {
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @inheritDoc
     */
    public function findUserByLogin(string $login): ?User
    {
        $entities = $this->findBy(['login' => $login]);
        $countEntities = count($entities);
        if ($countEntities > 1) {
            throw new RuntimeException('Найдены пользователи с дублирующимися логинами');
        }
        return 0 === $countEntities ? null : current($entities);
    }
}
