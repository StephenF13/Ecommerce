<?php

namespace EcommerceBundle\Listener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RedirectListener
{
    public function __construct(ContainerInterface $container, Session $session)
    {
        $this->session = $session;
        $this->router = $container->get('router');
        $this->securityContext = $container->get('security.token_storage');
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $route = $event->getRequest()->attributes->get('_route');

        if ($route == 'ecommerce_delivery' || $route == 'ecommerce_validation') {
            if ($this->session->has('basket')) {
                if (count($this->session->get('basket')) == 0) {
                    $event->setResponse(new RedirectResponse($this->router->generate('basket')));
                }
            }

            if (!is_object($this->securityContext->getToken()->getUser())) {
                $this->session->getFlashBag()->add('notification', 'Vous devez vous identifier');
                $event->setResponse(new RedirectResponse($this->router->generate('fos_user_security_login')));
            }
        }
    }
}