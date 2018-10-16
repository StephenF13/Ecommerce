<?php

namespace EcommerceBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use EcommerceBundle\Entity\Category;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $categorie1 = new Category();
        $categorie1->setName('Légumes');
        $categorie1->setImage($this->getReference('media1'));
        $manager->persist($categorie1);

        $categorie2 = new Category();
        $categorie2->setName('fruits');
        $categorie2->setImage($this->getReference('media2'));
        $manager->persist($categorie2);

        $manager->flush();

        $this->addReference('categorie1', $categorie1);
        $this->addReference('categorie2', $categorie2);
    }

    public function getOrder()
    {
        return 2;
    }
}