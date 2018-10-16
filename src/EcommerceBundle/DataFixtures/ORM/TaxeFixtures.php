<?php

namespace EcommerceBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use EcommerceBundle\Entity\Taxe;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class TaxeFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $tva1 = new Taxe();
        $tva1->setRate('0.982');
        $tva1->setName('TVA 1.75%');
        $tva1->setValue('1.75');
        $manager->persist($tva1);

        $tva2 = new Taxe();
        $tva2->setRate('0.833');
        $tva2->setName('TVA 20%');
        $tva2->setValue('20');
        $manager->persist($tva2);

        $manager->flush();

        $this->addReference('tva1', $tva1);
        $this->addReference('tva2', $tva2);

    }

    public function getOrder()
    {
        return 3;
    }
}