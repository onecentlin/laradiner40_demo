<?php declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Winnie\LaraDebut\ILogger;
use Winnie\LaraDebut\LogAnalyzer;

// 使用 Mockery 模擬框架
use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class LogAnalyzerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

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

    /** @test */
    public function analyze_TooShortFileName_CallLogger_UsingMockery()
    {
        // 建立模擬物件
        $logger = m::mock(ILogger::class);
        // 使用 Mockery API 來設定期望結果
        $logger->shouldReceive('logError')->once()
            ->with('Filename too short: a.txt');

        $analyzer = new LogAnalyzer($logger);
        $analyzer->minNameLength = 6;
        $analyzer->analyze("a.txt");
    }

}
