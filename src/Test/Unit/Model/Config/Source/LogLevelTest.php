<?php

declare(strict_types=1);

namespace CleatSquad\LogStream\Test\Unit\Model\Config\Source;

use PHPUnit\Framework\TestCase;
use CleatSquad\LogStream\Model\Config\Source\LogLevel;
use Monolog\Level;
use Monolog\Logger;

/**
 * Class LogLevelTest
 * @covers \CleatSquad\LogStream\Model\Config\Source\LogLevel
 */
class LogLevelTest extends TestCase
{
    /**
     * Test the toOptionArray method.
     */
    public function testToOptionArray(): void
    {
        $logLevel = new LogLevel();
        $options = $logLevel->toOptionArray();

        // Get the expected values based on Monolog version
        if (class_exists(Level::class)) {
            $expectedOptions = [
                ['value' => Level::Debug->value, 'label' => 'DEBUG'],
                ['value' => Level::Info->value, 'label' => 'INFO'],
                ['value' => Level::Notice->value, 'label' => 'NOTICE'],
                ['value' => Level::Warning->value, 'label' => 'WARNING'],
                ['value' => Level::Error->value, 'label' => 'ERROR'],
                ['value' => Level::Critical->value, 'label' => 'CRITICAL'],
                ['value' => Level::Alert->value, 'label' => 'ALERT'],
                ['value' => Level::Emergency->value, 'label' => 'EMERGENCY'],
            ];
        } else {
            $expectedOptions = [
                ['value' => Logger::DEBUG, 'label' => 'DEBUG'],
                ['value' => Logger::INFO, 'label' => 'INFO'],
                ['value' => Logger::NOTICE, 'label' => 'NOTICE'],
                ['value' => Logger::WARNING, 'label' => 'WARNING'],
                ['value' => Logger::ERROR, 'label' => 'ERROR'],
                ['value' => Logger::CRITICAL, 'label' => 'CRITICAL'],
                ['value' => Logger::ALERT, 'label' => 'ALERT'],
                ['value' => Logger::EMERGENCY, 'label' => 'EMERGENCY'],
            ];
        }

        $this->assertEquals($expectedOptions, $options);
    }
}
