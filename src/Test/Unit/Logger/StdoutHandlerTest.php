<?php

namespace CleatSquad\LogStream\Test\Unit\Logger;

use Monolog\Formatter\JsonFormatter;
use Monolog\Level;
use PHPUnit\Framework\TestCase;
use CleatSquad\LogStream\Logger\StdoutHandler;

/**
 * Class StdoutHandlerTest
 * @covers CleatSquad\LogStream\Logger\StdoutHandler
 */
class StdoutHandlerTest extends TestCase
{
    /**
     * Default INFO log level value
     */
    private const DEFAULT_INFO_LEVEL = 200;

    private function createStdoutHandler(): StdoutHandler
    {
        $formatter = new JsonFormatter();
        return new StdoutHandler($formatter);
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
        $this->assertEquals(self::DEFAULT_INFO_LEVEL, $this->getLevelValue($handler->getLevel()));
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
