<?php

namespace ws\controllers\frontend;

use common\helpers\LanguageHelper;
use common\models\domain\Content;
use common\models\domain\Language;
use common\models\web\Response;
use Yii;

/**
 * Content controller
 */
class ContentController extends BaseController
{

    protected $accessControlExceptActions = [
        'index'
    ];

    public function actionIndex()
    {
        $contentId = Yii::$app->request->get('id');
        $contentTag = Yii::$app->request->get('tag');
        $contentLanguage = Yii::$app->request->get('language');
        $canSearch = false;

        $query = Content::find();

        if (!empty($contentId)) {
            $query->andWhere(['id' => $contentId]);
            $canSearch = true;
        }

        if (!empty($contentTag)) {
            $query->andWhere(['tag' => $contentTag]);
            $canSearch = true;
        }

        if (empty($contentLanguage)) {
            $query->andWhere('(language_id = 0 OR language_id IS NULL)');
        } else {
            if ($contentLanguage == 'auto') {
                $preferredLanguage = LanguageHelper::getPreferredLanguage(Yii::$app->params['supportedLanguages']);

                if (empty($preferredLanguage)) {
                    $query->andWhere('(language_id = 0 OR language_id IS NULL)');
                } else {
                    $language = Language::find()->codeISO($preferredLanguage)->one();
                    $query->andWhere('(language_id = :preferred_language_id OR language_id = 0 OR language_id IS NULL)', ['preferred_language_id' => $language->id]);
                    $query->addOrderBy('language_id DESC');
                }
            } else {
                $query->andWhere(['language_id' => $contentLanguage]);
                $canSearch = true;
            }
        }

        if (!$canSearch) {
            $response = new Response();
            $response->setSuccess(false);
            $response->setMessage('not-found');

            return $response;
        }

        $query->andWhere(['status' => Content::STATUS_ACTIVE]);

        $content = $query->one();

        if ($content == null) {
            $response = new Response();
            $response->setSuccess(false);
            $response->setMessage('not-found');

            return $response;
        }

        $response = new Response();
        $response->setSuccess(true);
        $response->setMessage('found');
        $response->addData('content', $content);

        return $response;
    }

}
