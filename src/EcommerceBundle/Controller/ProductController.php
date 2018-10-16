<?php

namespace EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EcommerceBundle\Entity\Product;
use EcommerceBundle\Form\SearchType;
use Symfony\Component\HttpFoundation\Request;
use EcommerceBundle\Repository\ProductRepository;

class ProductController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository(Product::class)->findBy(['available' => 1]);

        return $this->render('EcommerceBundle:Product:index.html.twig', ['products' => $products]);
    }

    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException('La page n\'existe pas.');
        }

        return $this->render('EcommerceBundle:Product:view.html.twig', ['product' => $product]);
    }

    public function categoryAction($category)
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository(Product::class)->findBy(['category' => $category, 'available' => 1]);

        return $this->render('EcommerceBundle:Product:index.html.twig', ['products' => $products]);
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