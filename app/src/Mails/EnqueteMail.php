<?php

namespace App\Mails;

class EnqueteMail
{
  // private $userMail;
  private $target;
  private $structureId;
  private $baseUrl;

  public function __construct(string $target, int $structureId, $baseUrl)
  {
    // $this->user = $userMail;
    $this->target = $target;
    $this->structureId = $structureId;
    $this->baseUrl = $baseUrl;
  }

  // public function getUserMail()
  // {
  //   return $this->userMail;
  // }

  public function getTarget()
  {
    return $this->target;
  }
  public function getStructureId()
  {
    return $this->structureId;
  }
  public function getBaseUrl()
  {
    return $this->baseUrl;
  }
}
