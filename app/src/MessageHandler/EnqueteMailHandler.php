<?php

namespace App\MessageHandler;

use App\Mails\EnqueteMail;
use App\Service\AsyncMailService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class EnqueteMailHandler implements MessageHandlerInterface
{
  private AsyncMailService $mailService;

  public function __construct(AsyncMailService $mailService)
  {
    $this->mailService = $mailService;
  }

  public function __invoke(EnqueteMail $mail)
  {
    $structureId = $mail->getStructureId();
    $target = $mail->getTarget();
    $baseUrl = $mail->getBaseUrl();

    $this->mailService->sendToTarget($target, $structureId, $baseUrl);
  }
}
