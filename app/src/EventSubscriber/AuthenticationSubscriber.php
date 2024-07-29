<?php

namespace App\EventSubscriber;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class AuthenticationSubscriber implements EventSubscriberInterface
{
    private $jwtManager;

    public function __construct(JWTTokenManagerInterface $jwtManager)
    {
        $this->jwtManager = $jwtManager;
    }

    public function onSecurityInteractiveLogin(LoginSuccessEvent $event): void
    {
        // $user = $event->getUser();

        // $token = $this->jwtManager->create($user);

        // // Create an HttpOnly cookie with the token
        // $cookie = Cookie::create('jwt_token', $token)
        //     ->withHttpOnly(true)
        //     ->withSecure(true) // If served over HTTPS
        //     ->withSameSite('none');

        // // Inject the cookie into the response
        // $response = $event->getResponse();
        // $response->headers->setCookie($cookie);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LoginSuccessEvent::class => 'onSecurityInteractiveLogin',
        ];
    }
}
