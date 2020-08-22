<?php

namespace common\models\util;

use Yii;

class Logger
{

    public static function d($message)
    {
        self::message('DEBUG', $message);
    }

    public static function w($message)
    {
        self::message('WARNING', $message);
    }

    public static function e($message)
    {
        self::message('ERROR', $message);
    }

    public static function i($message)
    {
        self::message('INFO', $message);
    }

    public static function s($message)
    {
        self::message('SUCCESS', $message);
    }

    public static function f($message)
    {
        self::message('FATAL', $message);
        Yii::$app->end();
    }

    public static function message($prefix, $message)
    {
        echo("$prefix: $message\n");
    }

}