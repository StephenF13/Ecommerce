<?php

namespace EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BasketController extends Controller
{
    public function viewAction()
    {
        return $this->render('EcommerceBundle:Basket:view.html.twig');
    }

    public function deliveryAction()
    {
        return $this->render('EcommerceBundle:Basket:delivery.html.twig');
    }

    public function validationAction()
    {
        return $this->render('EcommerceBundle:Basket:validation.html.twig');
    }
}