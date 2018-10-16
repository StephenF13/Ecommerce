<?php

namespace EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EcommerceBundle\Entity\Category;

class CategoryController extends Controller
{


    public function menuCategoriesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository(Category::class)->findAll();


        return $this->render('EcommerceBundle::categories.html.twig', ['categories' => $categories]);
    }

}