<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Panther\PantherTestCase;
// use Goutte\Client;

class ScraperService extends PantherTestCase
{
  public function getPid($structureName, $cp)
  {
    $client = static::createPantherClient();
    // $client = new Client();

    $crawler = $client->request('GET', "http://www.google.fr/search?q=" . $structureName . "+" . $cp);


    // $pid = $crawler->filter('h1')->text();
    // dd($pid);

    $result = $crawler->filter('.VGHMXd')->each(function($node){
      return $node->text();
    });
  }
}
