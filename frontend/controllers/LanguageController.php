<?php

namespace frontend\controllers;

use common\helpers\LanguageHelper;
use common\models\domain\Language;
use Yii;

/**
 * Language controller
 */
class LanguageController extends BaseController
{

    protected $accessControlExceptActions = ['*'];

    public function actionChange()
    {
        $id = Yii::$app->request->get('id');
        $language = Language::findOne(['id' => $id]);

        if ($language) {
            LanguageHelper::setLanguageCookie($language->code_iso_language);
        }
    }

}
