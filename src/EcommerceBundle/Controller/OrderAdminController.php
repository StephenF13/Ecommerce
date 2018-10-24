<?php

namespace EcommerceBundle\Controller;

use EcommerceBundle\Entity\Orders;
use EcommerceBundle\Entity\Product;
use EcommerceBundle\Entity\UserAddress;
use EcommerceBundle\Form\UserAddressType;
use EcommerceBundle\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use EcommerceBundle\Services\GetReference;

class OrderAdminController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $orders = $em->getRepository(Orders::class)->findAll();

        return $this->render('EcommerceBundle:Admin:Order/index.html.twig',
            ['orders' => $orders]);
        
   }

    public function showAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository(Orders::class)->find($id);

        if (!$order) {
            $this->$request->getSession()->getFlashBag()->add('error', 'Facture non disponible');
            return $this->redirect($this->generateUrl('adminOrder_index'));
        }
        $this->get('setNewBill')->bill($order);

    }


}