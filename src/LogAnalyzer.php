<?php declare(strict_types=1);

namespace Winnie\LaraDebut;

class LogAnalyzer
{
    /**
     * @var ILogger
     */
    private $logger;

    public $minNameLength;

    public function __construct(ILogger $logger)
    {
        $this->logger = $logger;
    }

    public function analyze(string $fileName)
    {
        if (strlen($fileName) < $this->minNameLength) {
            $this->logger->logError("Filename too short: {$fileName}");
        }
    }
}
