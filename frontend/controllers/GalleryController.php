<?php

namespace frontend\controllers;

use common\helpers\LanguageHelper;
use common\models\domain\Content;
use common\models\domain\Gallery;
use common\models\domain\GalleryItem;
use common\models\domain\Language;
use Yii;
use yii\data\Pagination;

/**
 * Gallery controller
 */
class GalleryController extends BaseController
{

    protected $accessControlExceptActions = [
        '*'
    ];

    public function actionIndex()
    {
        $galleryId = Yii::$app->request->get('id');
        $galleryTag = Yii::$app->request->get('tag');
        $galleryLanguage = Yii::$app->request->get('language');
        $canSearch = false;
        $notFoundUrl = '@web/site/index';

        $query = Gallery::find();

        if (!empty($galleryId)) {
            $query->andWhere(['id' => $galleryId]);
            $canSearch = true;
        }

        if (!empty($galleryTag)) {
            $query->andWhere(['tag' => $galleryTag]);
            $canSearch = true;
        }

        if (empty($galleryLanguage)) {
            $galleryLanguage = 'auto';
        }

        if ($galleryLanguage == 'auto') {
            $preferredLanguage = LanguageHelper::getPreferredLanguage(Yii::$app->params['supportedLanguages']);

            if (empty($preferredLanguage)) {
                $query->andWhere('(language_id = 0 OR language_id IS NULL)');
            } else {
                $language = Language::find()->codeISO($preferredLanguage)->one();
                $query->andWhere('(language_id = :preferred_language_id OR language_id = 0 OR language_id IS NULL)', ['preferred_language_id' => $language->id]);
                $query->addOrderBy('language_id DESC');
            }
        } else {
            $query->andWhere(['language_id' => $galleryLanguage]);
        }

        if (!$canSearch) {
            $this->redirect($notFoundUrl);
            Yii::$app->end();
        }

        $query->andWhere(['status' => Content::STATUS_ACTIVE]);

        $gallery = $query->one();

        if ($gallery == null) {
            $this->redirect($notFoundUrl);
            Yii::$app->end();
        }

        $galleryImagesQuery = GalleryItem::find()->galleryId($gallery->id)->orderByOrder();
        $galleryImagesCount = $galleryImagesQuery->count();

        $pagination = new Pagination(['totalCount' => $galleryImagesCount]);
        $pagination->setPageSize((int)Yii::$app->params['gallery.images.items']);

        $galleryImageList = $galleryImagesQuery->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->render($this->action->id, [
            'gallery' => $gallery,
            'galleryImageList' => $galleryImageList,
            'pagination' => $pagination
        ]);
    }

    public function actionList()
    {
        $galleryTag = Yii::$app->request->get('tag');
        $galleryLanguage = Yii::$app->request->get('language');

        $query = Gallery::find();

        if (!empty($galleryTag)) {
            $query->andWhere(['tag' => $galleryTag]);
        }

        if (empty($galleryLanguage)) {
            $galleryLanguage = 'auto';
        }

        if ($galleryLanguage == 'auto') {
            $preferredLanguage = LanguageHelper::getPreferredLanguage(Yii::$app->params['supportedLanguages']);

            if (empty($preferredLanguage)) {
                $query->andWhere('(language_id = 0 OR language_id IS NULL)');
            } else {
                $language = Language::find()->codeISO($preferredLanguage)->one();
                $query->andWhere('(language_id = :preferred_language_id OR language_id = 0 OR language_id IS NULL)', ['preferred_language_id' => $language->id]);
                $query->addOrderBy('language_id DESC');
            }
        } else {
            $query->andWhere(['language_id' => $galleryLanguage]);
        }

        $query->andWhere(['status' => Content::STATUS_ACTIVE]);

        $count = $query->count();

        $pagination = new Pagination(['totalCount' => $count]);
        $pagination->setPageSize((int)Yii::$app->params['gallery.items']);

        $galleryList = $query->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->render($this->action->id, [
            'list' => $galleryList,
            'pagination' => $pagination
        ]);
    }

}
