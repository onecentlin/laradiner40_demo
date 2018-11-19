<?php declare(strict_types=1);

namespace Tests;

use Winnie\LaraDebut\ILogger;

class FakeLogger implements ILogger
{
    public $lastError;

    public function logError(string $message)
    {
        $this->lastError = $message;
    }
}
