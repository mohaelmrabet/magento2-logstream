<?php

namespace CleatSquad\LogStream\Test\Unit\Logger;

use Monolog\Formatter\JsonFormatter;
use Monolog\Level;
use PHPUnit\Framework\TestCase;
use CleatSquad\LogStream\Logger\StderrHandler;

/**
 * Class StderrHandlerTest
 * @covers CleatSquad\LogStream\Logger\StderrHandler
 */
class StderrHandlerTest extends TestCase
{
    /**
     * Default ERROR log level value
     */
    private const DEFAULT_ERROR_LEVEL = 400;

    private function createStderrHandler(): StderrHandler
    {
        $formatter = new JsonFormatter();
        return new StderrHandler($formatter);
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
        $this->assertInstanceOf(StderrHandler::class, $this->createStderrHandler());
    }

    public function testGetUrl(): void
    {
        $this->assertEquals('php://stderr', $this->createStderrHandler()->getUrl());
    }

    public function testGetLevel(): void
    {
        $handler = $this->createStderrHandler();
        $this->assertEquals(self::DEFAULT_ERROR_LEVEL, $this->getLevelValue($handler->getLevel()));
    }

    public function testGetBubble(): void
    {
        $this->assertFalse($this->createStderrHandler()->getBubble());
    }

    public function testGetFormatter(): void
    {
        $this->assertInstanceOf(JsonFormatter::class, $this->createStderrHandler()->getFormatter());
    }
}
