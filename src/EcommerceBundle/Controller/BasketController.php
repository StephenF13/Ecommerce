<?php

namespace EcommerceBundle\Controller;

use EcommerceBundle\Entity\Orders;
use EcommerceBundle\Entity\Product;
use EcommerceBundle\Entity\UserAddress;
use EcommerceBundle\Form\UserAddressType;
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

    public function deleteAddressAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $address = $em->getRepository(UserAddress::class)->find($id);

        if ($this->get('security.token_storage')->getToken()->getUser() != $address->getUser() || !$address) {
            return $this->redirect($this->generateUrl('ecommerce_delivery'));
        }

        $em->remove($address);
        $em->flush();

        return $this->redirect($this->generateUrl('ecommerce_delivery'));
    }

    public function deliveryAction(Request $request)
    {
//        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $userAddress = new UserAddress();
        $form = $this->createForm(UserAddressType::class, $userAddress);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $userAddress->setUser($user);
                $em->persist($userAddress);
                $em->flush();

                return $this->redirect($this->generateUrl('ecommerce_delivery'));
            }
        }

        return $this->render('EcommerceBundle:Basket:delivery.html.twig',
            ['form' => $form->createView(), 'user' => $user]);
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

    public function setDeliveryOnSession(Request $request)
    {
        $session = $request->getSession();

        if (!$session->has('address')) {
            $session->set('address', []);
        }

        $address = $session->get('address');

        if ($request->get('delivery') != null && $request->get('billing') != null) {
            $address['delivery'] = $request->get('delivery');
            $address['billing'] = $request->get('billing');
        } else {
            return $this->redirect($this->generateUrl('ecommerce_validation'));
        }

        $session->set('address', $address);

        return $this->redirect($this->generateUrl('ecommerce_validation'));
    }

    public function validationAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $this->setDeliveryOnSession($request);
        }

        $em = $this->getDoctrine()->getManager();
        $preOrder = $this->forward('EcommerceBundle:Order:preOrder');
        $orders = $em->getRepository(Orders::class)->find($preOrder->getContent());
        return $this->render('EcommerceBundle:Basket:validation.html.twig',
            [
                'orders' => $orders,
            ]);
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