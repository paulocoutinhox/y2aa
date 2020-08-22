<?php

namespace common\models\util;

use DateTime;

class DateTimeUtil
{

    public static function isValidDate($date)
    {
        return self::isValid($date, 'Y-m-d');
    }

    public static function isValidTime($date)
    {
        return self::isValid($date, 'H:i:s');
    }

    public static function isValid($date, $format = 'Y-m-d H:i:s')
    {
        $dateObj = DateTime::createFromFormat($format, $date);
        return $dateObj && $dateObj->format($format) == $date;
    }

}