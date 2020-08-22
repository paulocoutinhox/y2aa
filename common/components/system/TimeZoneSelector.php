<?php

namespace common\components\system;

use Yii;
use yii\base\BootstrapInterface;

class TimeZoneSelector implements BootstrapInterface
{

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->timeZone = Yii::$app->params['defaultTimeZone'];
        } else {
            Yii::$app->timeZone = Yii::$app->user->getIdentity()->timezone;
        }
    }

}