<?php

namespace EcommerceBundle\Services;

use Symfony\Component\Security\Core\Authentication\Token;
use Symfony\Component\Security\Core\Authentication\Token\Storage;
use Doctrine\ORM\EntityManager;
use EcommerceBundle\Entity\Orders;


class GetReference
{
    public function __construct(Storage\TokenStorage $tokenStorage, EntityManager $entityManager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->em = $entityManager;
    }

    public function reference()
    {
        $reference = $this->em->getRepository(Orders::class)->findOneBy(['status' => 1], ['id' => 'DESC'], 1, 1);

        if(!$reference) {
            return 1;
        } else {
            return $reference->getOrderNumber() +1;
        }
    }
}