<?php
namespace App;

use Monolog;

return [

    Monolog\Logger::class => function ($dic) : Monolog\Logger {
        $title      = dotenv('LOG_NAME');
        $handlers   = $dic->get('Monolog.Handlers');
        $processors = $dic->get('Monolog.Processors');

        return new Monolog\Logger($title, $handlers, $processors);
    },



    'Monolog.Handlers' => function( $dic ) : array {
        $config = $dic->get('App.Monolog');
        $handlers = $config['handlers'];

        return array_map(function($h) use ($dic) {
            return $dic->get($h);
        }, $handlers);
    },



    'Monolog.Processors' => function( $dic ) : array {
        $config = $dic->get('App.Monolog');
        $processors = $config['processors'];

        return array_map(function($h) use ($dic) {
            return $dic->get($h);
        }, $processors);
    },


    Monolog\Handler\RotatingFileHandler::class => function ($dic) : Monolog\Handler\HandlerInterface  {
        $logfile = dotenv('LOG_FILE');
        if (empty($logfile)) {
            return $dic->get(Monolog\Handler\NullHandler::class);
        }

        $max_files = dotenv('LOG_FILES_COUNT');
        $loglevel  = dotenv('LOG_FILE_LOGLEVEL');

        return new Monolog\Handler\RotatingFileHandler($logfile, $max_files, $loglevel);
    },


    Monolog\Handler\BrowserConsoleHandler::class => function ($dic) : Monolog\Handler\HandlerInterface  {
        $loglevel = dotenv('LOG_CONSOLE_LOGLEVEL');
        if (empty($loglevel)) {
            return $dic->get(Monolog\Handler\NullHandler::class);
        }
        return new Monolog\Handler\BrowserConsoleHandler($loglevel);
    },

    Monolog\Handler\NullHandler::class => function($dic) : Monolog\Handler\NullHandler {
        return new Monolog\Handler\NullHandler;
    },


    Monolog\Processor\PsrLogMessageProcessor::class => function($dic) : Monolog\Processor\ProcessorInterface {
        return new Monolog\Processor\PsrLogMessageProcessor();
    },

    Monolog\Processor\WebProcessor::class => function($dic) : Monolog\Processor\ProcessorInterface {
        return new Monolog\Processor\WebProcessor();
    },

];
