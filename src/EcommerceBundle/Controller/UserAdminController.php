<?php

namespace EcommerceBundle\Controller;

use EcommerceBundle\Entity\Orders;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EcommerceBundle\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use EcommerceBundle\Repository\OrdersRepository;
use Symfony\Component\HttpFoundation\Response;

class UserAdminController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findAll();

        return $this->render('EcommerceBundle:Admin:User/index.html.twig', ['users' => $users]);
    }

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);

        return $this->render('EcommerceBundle:Admin:User/show.html.twig', ['user' => $user]);
    }

}