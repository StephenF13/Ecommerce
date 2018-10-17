<?php

namespace EcommerceBundle\Controller;

use EcommerceBundle\Entity\Product;
use EcommerceBundle\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

class BasketController extends Controller
{
    public function addAction($id, Request $request)
    {
        $session = $request->getSession();

        if (!$session->has('basket')) {
            $session->set('basket', []);
        }
        $basket = $session->get('basket');

        if (array_key_exists($id, $basket)) {
            if ($request->query->get('qte') != null) {
                $basket[$id] = $request->query->get('qte');
            }
        } else {
            if ($request->query->get('qte') != null) {
                $basket[$id] = $request->query->get('qte');
            } else {
                $basket[$id] = 1;
            }
        }

        $session->set('basket', $basket);
        $session->getFlashBag()->add('success', 'L\'article a bien été ajouté à votre panier');

        return $this->redirect($this->generateUrl('ecommerce_basket'));
    }

    public function deleteAction($id, Request $request)
    {
        $session = $request->getSession();

        $basket = $session->get('basket');

        if (array_key_exists($id, $basket)) {
            unset($basket[$id]);
            $session->set('basket', $basket);
            $session->getFlashBag()->add('success', 'L\'article a bien été supprimé de votre panier');
        }

        return $this->redirect($this->generateUrl('ecommerce_basket'));
    }

    public function deliveryAction()
    {
        return $this->render('EcommerceBundle:Basket:delivery.html.twig');
    }

    public function menuAction(Request $request)
    {
        $session = $request->getSession();

        if (!$session->has('basket')) {
            $article = 0;
        } else {
            $article = count($session->get('basket'));
        }

        return $this->render('EcommerceBundle:Basket:menuBasket.html.twig', ['article' => $article]);

    }

    public function validationAction()
    {
        return $this->render('EcommerceBundle:Basket:validation.html.twig');
    }

    public function viewAction(Request $request)
    {
        $session = $request->getSession();

        if (!$session->has('basket')) {
            $session->set('basket', []);
        }

        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository(Product::class)->findBy(['id' => array_keys($session->get('basket'))]);

        return $this->render('EcommerceBundle:Basket:view.html.twig',
            ['products' => $products, 'basket' => $session->get('basket')]);
    }
}