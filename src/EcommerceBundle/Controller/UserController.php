<?php

namespace EcommerceBundle\Controller;

use EcommerceBundle\Entity\Orders;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EcommerceBundle\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use EcommerceBundle\Repository\OrdersRepository;
use Spipu\Html2Pdf\Html2Pdf;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function billAction()
    {
        $em = $this->getDoctrine()->getManager();
        $bill = $em->getRepository(Orders::class)->findByUser($this->getUser());

        return $this->render('EcommerceBundle:User:bill.html.twig', [
            'bill' => $bill,
        ]);

    }

    public function billPdfAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $bill = $em->getRepository(Orders::class)->findOneBy(['user' => $this->getUser(), 'status' => 1, 'id' => $id]);

        if (!$bill) {
            $this->$request->getSession()->getFlashBag()->add('error', 'Facture non disponible');
            return $this->redirect($this->generateUrl('bill'));
        }

        $this->get('setNewBill')->bill($bill);

    }



}