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

class OrderController extends Controller
{
    public function bill(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $address = $session->get('address');
        $basket = $session->get('basket');
        $orders = [];
        $totalHT = 0;
        $totalTTC = 0;

        $billing = $em->getRepository(UserAddress::class)->find($address['billing']);
        $delivery = $em->getRepository(UserAddress::class)->find($address['delivery']);
        $products = $em->getRepository(Product::class)->findBy(['id' => array_keys($session->get('basket'))]);

        foreach ($products as $product) {
            $priceHT = ($product->getPrice() * $basket[$product->getId()]);
            $priceTTC = ($product->getPrice() * $basket[$product->getId()] / $product->getTaxe()->getRate());
            $totalHT += $priceHT;
            $totalTTC += $priceTTC;

            if (!isset($orders['taxe']['%' . $product->getTaxe()->getValue()])) {
                $orders['taxe']['%' . $product->getTaxe()->getValue()] = round($priceTTC - $priceHT, 2);
            } else {
                $orders['taxe']['%' . $product->getTaxe()->getValue()] += round($priceTTC - $priceHT, 2);
            }

            $orders['product'][$product->getId()] = [
                'reference' => $product->getName(),
                'quantity'  => $basket[$product->getId()],
                'priceHT'   => round($product->getPrice(), 2),
                'priceTTC'  => round($product->getPrice() / $product->getTaxe()->getRate(), 2),
            ];
        }

        $orders['delivery'] = [
            'firstname'  => $delivery->getFirstname(),
            'name'       => $delivery->getName(),
            'telephone'  => $delivery->getPhone(),
            'address'    => $delivery->getAddress(),
            'postcode'   => $delivery->getPostcode(),
            'city'       => $delivery->getCity(),
            'country'    => $delivery->getCountry(),
            'complement' => $delivery->getComplement(),
        ];
        $orders['billing'] = [
            'firstname'  => $billing->getFirstname(),
            'name'       => $billing->getName(),
            'telephone'  => $billing->getPhone(),
            'address'    => $billing->getAddress(),
            'postcode'   => $billing->getPostcode(),
            'city'       => $billing->getCity(),
            'country'    => $billing->getCountry(),
            'complement' => $billing->getComplement(),
        ];
        $orders['priceHT'] = round($totalHT, 2);
        $orders['priceTTC'] = round($totalTTC, 2);
        $orders['token'] = bin2hex(random_bytes(20));

        return $orders;
    }

    public function preOrderAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();

        if (!$session->has('orders')) {
            $orders = new Orders();
        } else {
            $orders = $em->getRepository(Orders::class)->find($session->get(('orders')));
        }

        $orders->setDate(new \DateTime());
        $orders->setUser($this->get('security.token_storage')->getToken()->getUser());
        $orders->setStatus(0);
        $orders->setOrderNumber(0);
        $orders->setProduct($this->bill($request));

        if (!$session->has('orders')) {
            $em->persist($orders);
            $session->set('orders', $orders);
        }

        $em->flush(); // on flush sans persister si la commande existe déja

        return new Response($orders->getId());
    }


//    Methode API banque simulée
    public function validationOrderAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $orders = $em->getRepository(Orders::class)->find($id);

        if (!$orders || $orders->getStatus() == 1) {
            throw $this->createNotFoundException('La commande n\'existe pas');
        }

        $orders->setStatus(1);
        $orders->setOrderNumber($this->get('setNewReference')->reference());    //Service
        $em->flush();

        $session = $request->getSession();
        $session->remove('address');   // Commande ok, on supprime la session
        $session->remove('basket');
        $session->remove('orders');

        $this->get('session')->getFlashBag()->add('success','Votre commande est validée avec succès');
        return $this->redirect($this->generateUrl('bill'));
    }
}