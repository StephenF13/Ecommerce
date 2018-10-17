<?php

namespace EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EcommerceBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{


    public function menuCategoriesAction()
        {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository(Category::class)->findAll();


        return $this->render('EcommerceBundle::categories.html.twig',
            ['categories' => $categories]);
    }

}