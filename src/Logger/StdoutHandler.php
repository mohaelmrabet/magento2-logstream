<?php

declare(strict_types=1);

namespace CleatSquad\LogStream\Logger;

use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\StreamHandler;

/**
 * Class StdoutHandler
 * A handler that writes log messages to stdout.
 */
class StdoutHandler extends StreamHandler
{
    /**
     * Default log level value (INFO = 200)
     */
    private const DEFAULT_LOG_LEVEL = 200;

    public function __construct(FormatterInterface $formatter)
    {
        parent::__construct("php://stdout", self::DEFAULT_LOG_LEVEL, false);
        $this->setFormatter($formatter);
    }
}
