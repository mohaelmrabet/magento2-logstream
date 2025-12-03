<?php
/**
 * Copyright (c) 2024 Mohamed EL Mrabet
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
 * Class StdoutHandler
 * A handler that writes log messages to stdout.
 * Only handles DEBUG (100) to INFO (200) levels.
 */
class StdoutHandler extends StreamHandler
{
    /**
     * Minimum log level (DEBUG = 100)
     */
    private const MIN_LEVEL = 100;

    /**
     * Maximum log level (INFO = 200)
     */
    private const MAX_LEVEL = 200;

    public function __construct(FormatterInterface $formatter)
    {
        parent::__construct("php://stdout", self::MIN_LEVEL, false);
        $this->setFormatter($formatter);
    }

    /**
     * Check if this handler handles the given log record.
     * Only handles logs between DEBUG (100) and INFO (200).
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
