<?php


namespace App\Repository;


use Doctrine\ORM\EntityRepository;

/**
 * Class SubscriptionRepository
 * @package App\Repository
 */
class SubscriptionRepository extends EntityRepository
{
    public function getAllActiveSubscriptions()
    {
        $queryBuilder = $this->createQueryBuilder('s');
        return $queryBuilder->where($queryBuilder->expr()->eq('s.status', ':active'))
            ->setParameter(':active', 'active')
            ->getQuery()
            ->getResult();
    }

}