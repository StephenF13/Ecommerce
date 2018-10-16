<?php

namespace EcommerceBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use EcommerceBundle\Entity\UserAddress;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class UserAddressFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $adresse1 = new UserAddress();
        $adresse1->setUser($this->getReference('utilisateur1'));
        $adresse1->setName('Catelain');
        $adresse1->setFirstname('Benjamin');
        $adresse1->setPhone('0600000000');
        $adresse1->setAddress('3 rue alberta rubosca');
        $adresse1->setPostcode('76600');
        $adresse1->setCountry('France');
        $adresse1->setCity('Le Havre');
        $adresse1->setComplement('face à l\'église');
        $manager->persist($adresse1);

        $adresse2 = new UserAddress();
        $adresse2->setUser($this->getReference('utilisateur3'));
        $adresse2->setName('premier');
        $adresse2->setFirstname('albert');
        $adresse2->setPhone('0600000000');
        $adresse2->setAddress('5 rue rubosca');
        $adresse2->setPostcode('76600');
        $adresse2->setCountry('France');
        $adresse2->setCity('Le Havre');
        $adresse2->setComplement('face à la plage');
        $manager->persist($adresse2);

        $manager->flush();

    }

    public function getOrder()
    {
        return 6;
    }
}