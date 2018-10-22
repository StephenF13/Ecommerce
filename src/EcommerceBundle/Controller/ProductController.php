<?php

namespace EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EcommerceBundle\Entity\Product;
use EcommerceBundle\Form\SearchType;
use Symfony\Component\HttpFoundation\Request;
use EcommerceBundle\Repository\ProductRepository;
use EcommerceBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter;

class ProductController extends Controller
{
    public function indexAction(Request $request, Category $category = null)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();

        if ($category != null) {
            $productsQuery = $em->getRepository(Product::class)->findBy(['category' => $category, 'available' => 1]);
        } else {
            $productsQuery = $em->getRepository(Product::class)->findBy(['available' => 1]);
        }

        if ($session->has('basket')) {
            $basket = $session->get('basket');
        } else {
            $basket = false;
        }

        $paginator = $this->get('knp_paginator');
        $products = $paginator->paginate(
            $productsQuery, /* query NOT result */
            $request->query->getInt('page', 1) /*page number*/,
            2/*limit per page*/
        );


        return $this->render('EcommerceBundle:Product:index.html.twig',
            ['basket' => $basket, 'products' => $products]);
    }

    public function viewAction($id, Request $request)
    {
        $session = $request->getSession();

        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException('La page n\'existe pas.');
        }

        if ($session->has('basket')) {
            $basket = $session->get('basket');
        } else {
            $basket = false;
        }

        return $this->render('EcommerceBundle:Product:view.html.twig', ['product' => $product, 'basket' => $basket]);
    }

    public function searchAction()
    {
        $form = $this->createForm(SearchType::class);

        return $this->render('EcommerceBundle:Product:search.html.twig', ['form' => $form->createView()]);

    }

    public function searchResultAction(Request $request)
    {
        $form = $this->createForm(SearchType::class);

        if ($request->isMethod('POST')) {
            $form->submit($request->request->get($form->getName()));

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $products = $em->getRepository('EcommerceBundle:Product')->search($form['search']->getData());
            } else {
                throw $this->createNotFoundException('Le produit n\'existe pas.');
            }

            return $this->render('EcommerceBundle:Product:index.html.twig', ['products' => $products]);

        } else {
            throw $this->createNotFoundException('La page n\'existe pas.');
        }
    }
}