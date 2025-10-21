<?php

namespace App\Classe\ClasseSCPI;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Compare
{
  public function __construct(SessionInterface $session)
  {
    $this->session = $session;
  }

  public function add($id)
  {
    $compare = $this->session->get('compare', []);
    // verification que compare soit un tableau et compte les ellements
    $size = count((is_countable($compare) ? $compare : []));

    // teste l'absence de l'id dans comprare
    if (!in_array($id, $compare)) {
      // si il y a 3 element dans compare on fait shift(supperssion du 1er element)
      if ($size > 2) {
        array_shift($compare);
      }
      // on ajoute ID à compare
      $compare[] = $id;
    }
    // on stock compare dans la session
    $this->session->set('compare', $compare);
  }

  public function get()
  {
    return $this->session->get('compare');
  }

  public function remove()
  {
    $this->session->remove('compare');
  }
}
