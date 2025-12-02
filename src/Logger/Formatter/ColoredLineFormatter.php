<?php

declare(strict_types=1);

namespace CleatSquad\LogStream\Logger\Formatter;

use Monolog\Formatter\LineFormatter;
use Monolog\LogRecord;

/**
 * Class ColoredLineFormatter
 * A formatter that adds ANSI colors to log output for terminal display.
 */
class ColoredLineFormatter extends LineFormatter
{
    /**
     * ANSI color codes for each log level
     */
    private const COLORS = [
        'DEBUG' => "\033[36m",     // Cyan
        'INFO' => "\033[32m",      // Green
        'NOTICE' => "\033[34m",    // Blue
        'WARNING' => "\033[33m",   // Yellow
        'ERROR' => "\033[31m",     // Red
        'CRITICAL' => "\033[35m",  // Magenta
        'ALERT' => "\033[91m",     // Light Red
        'EMERGENCY' => "\033[97;41m", // White on Red background
    ];

    /**
     * ANSI reset code
     */
    private const RESET = "\033[0m";

    /**
     * Default format with timestamp, level, and message
     */
    private const DEFAULT_FORMAT = "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n";

    public function __construct(
        ?string $format = null,
        ?string $dateFormat = null,
        bool $allowInlineLineBreaks = false,
        bool $ignoreEmptyContextAndExtra = true
    ) {
        parent::__construct(
            $format ?? self::DEFAULT_FORMAT,
            $dateFormat,
            $allowInlineLineBreaks,
            $ignoreEmptyContextAndExtra
        );
    }

    /**
     * Format the log record with ANSI colors
     *
     * @param LogRecord|array $record
     * @return string
     */
    public function format(LogRecord|array $record): string
    {
        // Get level name - handle both Monolog 2.x (array) and 3.x (LogRecord)
        if ($record instanceof LogRecord) {
            // Monolog 3.x: level->name returns 'Info', 'Error', etc.
            $levelName = strtoupper($record->level->name);
        } else {
            // Monolog 2.x: level_name is array key, already uppercase
            $levelName = $record['level_name'] ?? 'INFO';
        }

        $color = self::COLORS[$levelName] ?? '';
        $output = parent::format($record);

        if ($color !== '') {
            return $color . $output . self::RESET;
        }

        return $output;
    }
}
