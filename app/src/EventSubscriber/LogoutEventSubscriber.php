<?php

namespace App\EventSubscriber;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
// use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class LogoutEventSubscriber implements EventSubscriberInterface
{
    private $urlGenerator;
    private $flash;
    private $session;

    public function __construct(UrlGeneratorInterface $urlGenerator, RequestStack $requestStack)
    {
        $this->urlGenerator = $urlGenerator;
        $this->session = $requestStack->getSession();
    }

    public function onLogoutEvent(LogoutEvent $event)
    {

        $this->session->clear();
        $this->flash = $this->session->getFlashBag();
        $this->flash->add(
            'success',
            'Deconnexion réussie!'
        );

        $event->setResponse(new RedirectResponse($this->urlGenerator->generate('app_login')));
    }

    public static function getSubscribedEvents()
    {
        return [
            LogoutEvent::class => 'onLogoutEvent',
        ];
    }
}
