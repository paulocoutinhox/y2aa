<?php

namespace common\helpers;

class SimpleArrayHelper
{

    public static function map($data)
    {
        $list = [];

        foreach ($data as $index => $value) {
            $list[$index] = $value;
        }

        return $list;
    }

}