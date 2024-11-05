<?php

namespace App\Service;

class UniqIdService
{

  function generer_identifiant_unique($entered_id)
  {

    $id_str = strval($entered_id);

    $hash = hash('sha256', $id_str);

    $hash_int = hexdec(substr($hash, 0, 15));

    $result_id = $hash_int % 1000000;

    return str_pad($result_id, 6, '0', STR_PAD_LEFT);
  }
}
