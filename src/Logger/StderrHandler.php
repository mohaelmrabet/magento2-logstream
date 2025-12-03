<?php
/**
 * Copyright (c) 2025 Mohamed EL Mrabet
 * CleatSquad - https://cleatsquad.dev
 *
 * This file is part of the CleatSquad_LogStream module.
 * Licensed under the MIT License. See the LICENSE file in the module root.
 */
declare(strict_types=1);

namespace CleatSquad\LogStream\Logger;

use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\LogRecord;

/**
 * Class StderrHandler
 * A handler that writes error log messages to stderr.
 * Only handles WARNING (300) to EMERGENCY (600) levels.
 */
class StderrHandler extends StreamHandler
{
    /**
     * Minimum log level (WARNING = 300)
     */
    private const MIN_LEVEL = 300;

    /**
     * Maximum log level (EMERGENCY = 600)
     */
    private const MAX_LEVEL = 600;

    public function __construct(FormatterInterface $formatter)
    {
        parent::__construct("php://stderr", self::MIN_LEVEL, false);
        $this->setFormatter($formatter);
    }

    /**
     * Check if this handler handles the given log record.
     * Only handles logs between WARNING (300) and EMERGENCY (600).
     *
     * @param LogRecord|array $record
     * @return bool
     */
    public function isHandling(LogRecord|array $record): bool
    {
        // Get level value - handle both Monolog 2.x (array) and 3.x (LogRecord)
        if ($record instanceof LogRecord) {
            $level = $record->level->value;
        } else {
            $level = $record['level'] ?? 0;
        }

        return $level >= self::MIN_LEVEL && $level <= self::MAX_LEVEL;
    }
}
