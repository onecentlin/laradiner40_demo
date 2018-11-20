<?php declare(strict_types=1);

namespace Tests;

use Winnie\LaraDebut\ILogger;

// 用虛設常式來模擬 logger 拋出例外
class FakeLogger2 implements ILogger
{
    /** @var \Exception */
    public $willThrow = null;
    public $loggerGotMessage;

    public function logError(string $message)
    {
         $this->loggerGotMessage = $message;
         if ($this->willThrow != null) {
             throw $this->willThrow;
         }
    }
}