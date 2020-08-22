<?php

namespace common\components\system;

use common\helpers\LanguageHelper;
use Yii;
use yii\base\BootstrapInterface;

class LanguageSelector implements BootstrapInterface
{

    public $supportedLanguages = [];
    public $createCookie = true;

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $preferredLanguage = LanguageHelper::getPreferredLanguage($this->supportedLanguages);

        if (!empty($preferredLanguage)) {
            Yii::$app->language = $preferredLanguage;

            if ($this->createCookie === true) {
                LanguageHelper::setLanguageCookie($preferredLanguage);
            }
        }
    }

}