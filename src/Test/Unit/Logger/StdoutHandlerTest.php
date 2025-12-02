<?php

namespace CleatSquad\LogStream\Test\Unit\Logger;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Monolog\Formatter\JsonFormatter;
use Monolog\Level;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use CleatSquad\LogStream\Logger\StdoutHandler;
use Monolog\Logger;

/*
 * Class StdoutHandlerTest
 * @covers CleatSquad\LogStream\Logger\StdoutHandler
 */
class StdoutHandlerTest extends TestCase
{
    private function createStdoutHandler(MockObject|null $scopeConfigMock = null): StdoutHandler
    {
        if ($scopeConfigMock === null) {
            $scopeConfigMock = $this->createMock(ScopeConfigInterface::class);
        }
        $formatter = new JsonFormatter();
        /** @var ScopeConfigInterface $scopeConfigMock */
        return new StdoutHandler($scopeConfigMock, $formatter);
    }

    /**
     * Get the integer value from a log level (handles both Monolog 2.x and 3.x)
     *
     * @param int|Level $level
     * @return int
     */
    private function getLevelValue(int|Level $level): int
    {
        if ($level instanceof Level) {
            return $level->value;
        }
        return $level;
    }

    public function testIsInstanceOfStreamHandler(): void
    {
        $this->assertInstanceOf(StdoutHandler::class, $this->createStdoutHandler());
    }

    public function testGetUrl(): void
    {
        $this->assertEquals('php://stdout', $this->createStdoutHandler()->getUrl());
    }

    public function testGetLevel(): void
    {
        $handler = $this->createStdoutHandler();
        $expectedLevel = class_exists(Level::class) ? Level::Info->value : Logger::INFO;
        $this->assertEquals($expectedLevel, $this->getLevelValue($handler->getLevel()));
    }

    public function testGetLevelFromConfig(): void
    {
        $scopeConfigMock = $this->createMock(ScopeConfigInterface::class);
        $warningLevel = class_exists(Level::class) ? Level::Warning->value : Logger::WARNING;
        /** @var MockObject $scopeConfigMock */
        $scopeConfigMock->expects($this->once())
            ->method('getValue')
            ->with('general/logging/log_level', 'website')
            ->willReturn($warningLevel);
        $this->assertEquals($warningLevel, $this->getLevelValue($this->createStdoutHandler($scopeConfigMock)->getLevel()));
    }

    public function testGetBubble(): void
    {
        $this->assertFalse($this->createStdoutHandler()->getBubble());
    }

    public function testGetFormatter(): void
    {
        $this->assertInstanceOf(JsonFormatter::class, $this->createStdoutHandler()->getFormatter());
    }
}
