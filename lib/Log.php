<?php

namespace Lib;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Log
{
    private static $instance;

    private static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Logger('jfix');
            self::$instance->pushHandler(
                new StreamHandler(
                    __ROOT__ . DIRECTORY_SEPARATOR
                    . 'storage' . DIRECTORY_SEPARATOR
                    . 'log' . DIRECTORY_SEPARATOR
                    . date('Y-m-d') . '.log'
                )
            );
        }

        return self::$instance;
    }

    public static function debug($msg = '', $context = [])
    {
        self::getInstance()->debug($msg, $context);
    }

    public static function info($msg = '', $context = [])
    {
        self::getInstance()->info($msg, $context);
    }

    public static function notice($msg = '', $context = [])
    {
        self::getInstance()->notice($msg, $context);
    }

    public static function warning($msg = '', $context = [])
    {
        self::getInstance()->warning($msg, $context);
    }

    public static function error($msg = '', $context = [])
    {
        self::getInstance()->error($msg, $context);
    }

    public static function critical($msg = '', $context = [])
    {
        self::getInstance()->critical($msg, $context);
    }

    public static function alert($msg = '', $context = [])
    {
        self::getInstance()->alert($msg, $context);
    }

}