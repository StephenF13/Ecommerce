<?php

namespace EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    public function indexAction()
    {
        return $this->render('EcommerceBundle:Product:index.html.twig');
    }

    public function viewAction()
    {
        return $this->render('EcommerceBundle:Product:view.html.twig');
    }

}