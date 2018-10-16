<?php

namespace EcommerceBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use EcommerceBundle\Entity\Orders;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class OrdersFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $commande1 = new Orders();
        $commande1->setUser($this->getReference('utilisateur1'));
        $commande1->setStatus('1');
        $commande1->setDate(new \DateTime());
        $commande1->setOrderNumber('1');
        $commande1->setProduct([
            '0' => ['1' => '2'],
            '1' => ['2' => '1'],
            '2' => ['4' => '5'],
        ]);
        $manager->persist($commande1);

        $commande2 = new Orders();
        $commande2->setUser($this->getReference('utilisateur3'));
        $commande2->setStatus('1');
        $commande2->setDate(new \DateTime());
        $commande2->setOrderNumber('2');
        $commande2->setProduct([
            '0' => ['1' => '2'],
            '1' => ['2' => '1'],
            '2' => ['4' => '5'],
        ]);
        $manager->persist($commande2);
        $manager->flush();
    }

    public function getOrder()
    {
        return 7;
    }
}