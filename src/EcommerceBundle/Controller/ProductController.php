<?php

namespace EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EcommerceBundle\Entity\Product;

class ProductController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository(Product::class)->findAll();

        return $this->render('EcommerceBundle:Product:index.html.twig', ['products' => $products]);
    }

    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)->find($id);

        return $this->render('EcommerceBundle:Product:view.html.twig', ['product' => $product]);
    }

    public function categoryAction($category)
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository(Product::class)->findBy(['category' => $category]);

        return $this->render('EcommerceBundle:Product:index.html.twig', ['products' => $products]);
    }
}