<?php declare(strict_types=1);

namespace Winnie\LaraDebut;

class LogAnalyzer2
{
    /** @var ILogger */
    private $logger;
    /** @var IWebService */
    private $webService;
    public $minNameLength;

    public function __construct(ILogger $logger, IWebService $webService)
    {
        $this->logger = $logger;
        $this->webService = $webService;
    }

    public function analyze($filename)
    {
        if (strlen($filename) < $this->minNameLength) {
            try {
                $this->logger->logError("Filename too short: {$filename}");
            } catch (\Exception $e) {
                $this->webService->write("Error From Logger: {$e->getMessage()}");
            }
        }
    }
}
