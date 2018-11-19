<?php declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Winnie\LaraDebut\LogAnalyzer;

class LogAnalyzerTest extends TestCase
{
    /** @test */
    public function analyze_TooShortFileName_CallLogger()
    {
        // 建立假物件
        $logger = new FakeLogger();

        $analyzer = new LogAnalyzer($logger);
        $analyzer->minNameLength = 6;
        $analyzer->analyze("a.txt");

        // 把假物件當模擬物件來使用並驗證
        $this->assertContains("too short", $logger->lastError);
    }
}
