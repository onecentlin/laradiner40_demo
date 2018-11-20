<?php declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Winnie\LaraDebut\IFileNameRules;
use Winnie\LaraDebut\ILogger;
use Winnie\LaraDebut\IWebService;
use Winnie\LaraDebut\LogAnalyzer;

// 使用 Mockery 模擬框架
use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Winnie\LaraDebut\LogAnalyzer2;

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

    /** @test */
    public function analyze_TooShortFileName_CallLogger_UsingMockerySpy()
    {
        // 建立模擬物件
        $logger = m::spy(ILogger::class);

        $analyzer = new LogAnalyzer($logger);
        $analyzer->minNameLength = 6;
        $analyzer->analyze("a.txt");

        // 使用 Mockery API 來設定期望結果
        $logger->shouldHaveReceived('logError')->once()
            ->with('Filename too short: a.txt');
    }

    /** @test */
    public function returns_ByDefault_WorksForHardCodedArgument()
    {
        $fakeRules = m::mock(IFileNameRules::class);
        // 強制方法被呼叫時要回傳假的值
        $fakeRules->shouldReceive('isValidLogFileName')->once()
            ->with('strict.txt')->andReturn(true);

        $this->assertTrue($fakeRules->isValidLogFileName('strict.txt'));
    }

    /** @test */
    public function analyze_LoggerThrows_CallsWebService()
    {
        $mockWebService = new FakeWebService();
        $stubLogger = new FakeLogger2();
        $stubLogger->willThrow = new \Exception("fake exception");

        $analyzer2 = new LogAnalyzer2($stubLogger, $mockWebService);
        $analyzer2->minNameLength = 8;
        $tooShortFileName = "abc.ext";
        $analyzer2->analyze($tooShortFileName);

        $this->assertContains("fake exception", $mockWebService->messageToWebService);
    }

    /** @test */
    public function analyze_LoggerThrows_CallsWebService_UsingMockery()
    {
        $mockWebService = m::spy(IWebService::class);

        $stubLogger = m::mock(ILogger::class);
        $stubLogger->shouldReceive('logError')
            ->with(
                // 不論輸入任何參數, 模擬拋出例外的行為
                m::on(function($message) {
                    throw new \Exception("fake exception");
                })
            );

        $analyzer2 = new LogAnalyzer2($stubLogger, $mockWebService);
        $analyzer2->minNameLength = 8;
        $tooShortFileName = "abc.ext";
        $analyzer2->analyze($tooShortFileName);

        // 確認 web 服務的模擬物件有被正確呼叫, 而且傳入的字串參數包含了 fake exception 的內容
        $mockWebService->shouldHaveReceived('write')->once()
            ->with(
                m::on(function($message) {
                    return strpos($message, 'fake exception') !== false;
                })
            );
    }
}
