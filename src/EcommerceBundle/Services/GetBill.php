<?php

namespace EcommerceBundle\Services;

use Symfony\Component\Security\Core\Authentication\Token;
use Symfony\Component\Security\Core\Authentication\Token\Storage;
use Doctrine\ORM\EntityManager;
use EcommerceBundle\Entity\Orders;
use Symfony\Component\DependencyInjection\Container;
use Spipu\Html2Pdf\Html2Pdf;
use EcommerceBundle\Repository\OrdersRepository;
use Symfony\Component\HttpFoundation\Response;


class GetBill
{
    public function __construct(Container $container)
    {
        $this->container = $container;

    }

    public function bill($bill)
    {
        $html = $this->container->get('templating')->render('EcommerceBundle:User:billPdf.html.twig', array('bill' => $bill));

        $html2pdf = new Html2Pdf('P','A4','fr');
        $html2pdf->pdf->SetAuthor('Demo');
        $html2pdf->pdf->SetTitle('Facture ' .$bill->getOrderNumber());
        $html2pdf->pdf->SetSubject('Facture Demo');
        $html2pdf->pdf->SetKeywords('facture, demo');
        $html2pdf->pdf->SetDisplayMode('real');
        $html2pdf->writeHTML($html);
        $html2pdf->output('Invoice.pdf');

        $response = new Response();
        $response->headers->set('Content-type' , 'application/pdf');

        return $response;
    }


}