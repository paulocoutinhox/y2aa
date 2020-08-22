<?php

namespace common\components\formatter;

use yii\i18n\Formatter;

class SimpleFormatter extends Formatter
{

    public static function asCEP($value)
    {
        return substr($value, 0, 5) . '-' . substr($value, 5);
    }

    public static function asCPF($value)
    {
        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $value);
    }

    public static function asCNPJ($value)
    {
        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $value);
    }

    public static function asPhone($value)
    {
        $value = preg_replace("/[^0-9]/", "", $value);
        $len = strlen($value);

        if ($len == 13) { // COM CÓDIGO DE ÁREA NACIONAL E DO PAIS e 9 dígitos
            return "+" . substr($value, 0, $len - 11) . "(" . substr($value, $len - 11, 2) . ")" . substr($value, $len - 9, 5) . "-" . substr($value, -4);
        }
        if ($len == 12) { // COM CÓDIGO DE ÁREA NACIONAL E DO PAIS
            return "+" . substr($value, 0, $len - 10) . "(" . substr($value, $len - 10, 2) . ")" . substr($value, $len - 8, 4) . "-" . substr($value, -4);
        }
        if ($len == 11) { // COM CÓDIGO DE ÁREA NACIONAL e 9 dígitos
            return "(" . substr($value, 0, 2) . ")" . substr($value, 2, 5) . "-" . substr($value, 7, 11);
        }
        if ($len == 10) { // COM CÓDIGO DE ÁREA NACIONAL
            return "(" . substr($value, 0, 2) . ")" . substr($value, 2, 4) . "-" . substr($value, 6, 10);
        }
        if ($len <= 9) { // SEM CÓDIGO DE ÁREA
            return substr($value, 0, $len - 4) . "-" . substr($value, -4);
        }

        return null;
    }

}