<?php

namespace EcommerceBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use EcommerceBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends AbstractFixture implements OrderedFixtureInterface
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $utilisateur1 = new User();
        $utilisateur1->setUsername('benjamin');
        $utilisateur1->setEmail('benjamin@gmail.com');
        $utilisateur1->setEnabled(1);
        $password1 = $this->encoder->encodePassword($utilisateur1,'poupou');
        $utilisateur1->setPassword($password1);
        $manager->persist($utilisateur1);

        $utilisateur2 = new User();
        $utilisateur2->setUsername('mathilde');
        $utilisateur2->setEmail('mathilde@gmail.com');
        $utilisateur2->setEnabled(1);
        $password2 = $this->encoder->encodePassword($utilisateur2,'mathilde');
        $utilisateur2->setPassword($password2);
        $manager->persist($utilisateur2);

        $utilisateur3 = new User();
        $utilisateur3->setUsername('pauline');
        $utilisateur3->setEmail('pauline@gmail.com');
        $utilisateur3->setEnabled(1);
        $password3 = $this->encoder->encodePassword($utilisateur3,'pauline');
        $utilisateur3->setPassword($password3);
        $manager->persist($utilisateur3);

        $utilisateur4 = new User();
        $utilisateur4->setUsername('tiffany');
        $utilisateur4->setEmail('tiffany@gmail.com');
        $utilisateur4->setEnabled(1);
        $password4 = $this->encoder->encodePassword($utilisateur4,'tiffany');
        $utilisateur4->setPassword($password4);
        $manager->persist($utilisateur4);

        $utilisateur5 = new User();
        $utilisateur5->setUsername('dominique');
        $utilisateur5->setEmail('dominique@gmail.com');
        $utilisateur5->setEnabled(1);
        $password5 = $this->encoder->encodePassword($utilisateur5,'dominique');
        $utilisateur5->setPassword($password5);
        $manager->persist($utilisateur5);

        $manager->flush();

        $this->addReference('utilisateur1', $utilisateur1);
        $this->addReference('utilisateur2', $utilisateur2);
        $this->addReference('utilisateur3', $utilisateur3);
        $this->addReference('utilisateur4', $utilisateur4);
        $this->addReference('utilisateur5', $utilisateur5);
    }

    public function getOrder()
    {
        return 5;
    }
}