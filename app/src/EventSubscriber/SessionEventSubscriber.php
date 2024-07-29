<?php

namespace App\EventSubscriber;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class SessionEventSubscriber
{
    private $session;

    public function __construct(RequestStack $requestStack)
    {
        $this->session = $requestStack->getSession();
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $this->session->clear();
    }
}
