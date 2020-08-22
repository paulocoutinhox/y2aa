<?php

namespace common\components\validator;

use DateTimeZone;
use Yii;
use yii\validators\Validator;

class TimeZoneValidator extends Validator
{
    public function validateValue($value)
    {
        $list = DateTimeZone::listIdentifiers();

        if (!in_array($value, $list)) {
            return [Yii::t('common', 'TimeZone.Validator.Invalid'), []];
        }
    }
}