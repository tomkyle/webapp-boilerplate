<?php

/**
 * PHP Slim4 Web App Boilerplate (https://github.com/tomkyle/webapp-boilerplate)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tests;

use Psr\Log\NullLogger;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Bramus\Monolog\Formatter\ColoredLineFormatter;

trait LoggerTrait
{
    /**
     * @var null|\Psr\Log\LoggerInterface
     */
    public static $logger;

    /**
     * \Psr\Log\LogLevel constant value
     * @var null|string
     */
    public static $loglevel;



    public static function getLogger(): LoggerInterface
    {
        if (static::$logger instanceof LoggerInterface) {
            return static::$logger;
        }

        $logger = static::createMonologLogger();
        static::setLogger($logger);
        return static::$logger;
    }

    public static function setLogger(LoggerInterface $logger): void
    {
        static::$logger = $logger;
    }



    public static function getLogLevel(): string
    {
        if (!empty(static::$loglevel)) {
            return static::$loglevel;
        }
        static::setLogLevel($GLOBALS['LOG_LEVEL'] ?? \Psr\Log\LogLevel::DEBUG);
        return static::$loglevel;
    }


    public static function setLogLevel(string $loglevel): void
    {
        static::$loglevel = $loglevel;
    }



    protected static function createMonologLogger(): LoggerInterface
    {
        $stream = $GLOBALS['LOG_STREAM'] ?? "php://stdout";
        $loglevel = static::getLogLevel();

        /* @phpstan-ignore-next-line */
        $handler = new StreamHandler($stream, $loglevel);

        // As defined in \Monolog\Formatter\LineFormatter::SIMPLE_FORMAT
        $format      = "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n";
        // Use default (same as omit parameter)
        $format = null;
        // We omit the %channel% name
        $format      = "[%datetime%] %level_name%: %message% %context% %extra%\n";


        // As defined in \Monolog\Formatter\NormalizerFormatter::SIMPLE_DATE
        $date_format = "Y-m-d\TH:i:sP";
        // Use default (same as omit parameter)
        $date_format = null;
        // We use shorter time format
        $date_format = "H:i:s.v";

        // Disable until bramus/monolog-colored-line-formatter 'format' method has proper rturn type
        # $handler->setFormatter(new ColoredLineFormatter(null, $format, $date_format));

        return new Logger("phpunit", [$handler]);
    }
}
