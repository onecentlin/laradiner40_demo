<?php declare(strict_types=1);

namespace Tests;

use Winnie\LaraDebut\IWebService;

class FakeWebService implements IWebService
{
    public $messageToWebService;

    public function write(string $message)
    {
        $this->messageToWebService = $message;
    }
}
