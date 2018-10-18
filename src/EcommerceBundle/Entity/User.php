<?php

namespace EcommerceBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        $this->orders = new ArrayCollection();
        $this->address = new ArrayCollection();

        // your own logic
    }

    /**
     *
     * @ORM\OneToMany(targetEntity="EcommerceBundle\Entity\Orders", mappedBy="user", cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $orders;

    /**
    *
    * @ORM\OneToMany(targetEntity="EcommerceBundle\Entity\UserAddress", mappedBy="user", cascade={"remove"})
    * @ORM\JoinColumn(nullable=true)
    */
    private $address;


    public function getId()
    {
        return $this->id;
    }

    public function addOrders(Orders $orders)
    {
        $this->orders[] = $orders;
        return $this;
    }


    public function removeOrder(Orders $orders)
    {
        $this->orders->removeElement($orders);
    }

    public function getOrders()
    {
        return $this->orders;
    }

    public function addAddress(UserAddress $address)
    {
        $this->address[] = $address;
        return $this;
    }

    public function removeAddress(UserAddress $address)
    {
        $this->address->removeElement($address);
    }

    public function getAddress()
    {
        return $this->address;
    }
}
