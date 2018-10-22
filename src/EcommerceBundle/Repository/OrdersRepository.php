<?php

namespace EcommerceBundle\Repository;


class OrdersRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByUser($user)
    {
        $qb = $this->createQueryBuilder('o')->select('o')->where('o.user = :user')->andWhere('o.status = 1')->andWhere('o.orderNumber != 0')->orderBy('o.id')->setParameter('user',
            $user);

        return $qb->getQuery()->getResult();
    }

}
