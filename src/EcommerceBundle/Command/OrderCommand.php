<?php

namespace EcommerceBundle\Command;

use EcommerceBundle\Entity\Orders;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OrderCommand extends ContainerAwareCommand
{


    public function configure()
    {
        $this->setName('order:number')->setDescription('connaitre le nombre de commandes');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $orders = $this->getContainer()->get('doctrine')->getManager()->getRepository(Orders::class)->findAll();

        $output->writeln('Il y a ' . count($orders) . ' factures pour le moment');
    }
}