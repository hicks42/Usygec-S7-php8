<?php

namespace App\EventSubscriber;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class JWTAuthenticationSubscriber implements EventSubscriberInterface
{
  private $jwtManager;

  public function __construct(JWTTokenManagerInterface $jwtManager)
  {
    $this->jwtManager = $jwtManager;
  }

  public static function getSubscribedEvents()
  {
    return [
      AuthenticationSuccessEvent::class => 'onAuthenticationSuccess',
    ];
  }

  public function onAuthenticationSuccess(AuthenticationSuccessEvent $event)
  {

    // $user = $event->getUser();

    // // Générez un token JWT pour cet utilisateur
    // $token = $this->jwtManager->create($user);

    // // Create an HttpOnly cookie with the token
    // $cookie = Cookie::create('jwt_token', $token)
    //   ->withHttpOnly(false)
    //   ->withSecure(true) // If served over HTTPS
    //   ->withSameSite('none');

    // // Inject the cookie into the response
    // $response = $event->getResponse();
    // $response->headers->setCookie($cookie);
  }
}
