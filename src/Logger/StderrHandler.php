<?php

declare(strict_types=1);

namespace CleatSquad\LogStream\Logger;

use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\StreamHandler;

/**
 * Class StderrHandler
 * A handler that writes error log messages to stderr.
 */
class StderrHandler extends StreamHandler
{
    /**
     * Default log level value (ERROR = 400)
     */
    private const DEFAULT_LOG_LEVEL = 400;

    public function __construct(FormatterInterface $formatter)
    {
        parent::__construct("php://stderr", self::DEFAULT_LOG_LEVEL, false);
        $this->setFormatter($formatter);
    }
}
