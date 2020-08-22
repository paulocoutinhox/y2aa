<?php

namespace ws\controllers\frontend;

use common\helpers\LanguageHelper;
use common\models\domain\Gallery;
use common\models\domain\GalleryItem;
use common\models\domain\Language;
use common\models\web\Response;
use Yii;
use yii\data\Pagination;
use yii\helpers\Url;

/**
 * Gallery controller
 */
class GalleryController extends BaseController
{

    protected $accessControlExceptActions = [
        'index', 'list'
    ];

    public function actionIndex()
    {
        $galleryId = Yii::$app->request->get('id');
        $galleryTag = Yii::$app->request->get('tag');
        $galleryLanguage = Yii::$app->request->get('language');
        $canSearch = false;

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
            $query->andWhere('(language_id = 0 OR language_id IS NULL)');
        } else {
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
                $canSearch = true;
            }
        }

        if (!$canSearch) {
            $response = new Response();
            $response->setSuccess(false);
            $response->setMessage('not-found');

            return $response;
        }

        $query->andWhere(['status' => Gallery::STATUS_ACTIVE]);

        $gallery = $query->one();

        if ($gallery == null) {
            $response = new Response();
            $response->setSuccess(false);
            $response->setMessage('not-found');

            return $response;
        }

        $images = $gallery->getGalleryItems()->orderBy('order')->asArray()->all();

        foreach ($images as $index => $image) {
            $images[$index]['image_url'] = Url::to(($images[$index]['base_url'] . '/' . $images[$index]['path']), true);
        }

        $response = new Response();
        $response->setSuccess(true);
        $response->setMessage('found');
        $response->addData('gallery', $gallery);
        $response->addData('images', $images);

        return $response;
    }

    public function actionList()
    {
        $galleryTag = Yii::$app->request->get('tag');
        $galleryLanguage = Yii::$app->request->get('language');
        $canSearch = false;

        $query = Gallery::find();

        if (!empty($galleryTag)) {
            $query->andWhere(['tag' => $galleryTag]);
            $canSearch = true;
        }

        if (empty($galleryLanguage)) {
            $query->andWhere('(language_id = 0 OR language_id IS NULL)');
        } else {
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
                $canSearch = true;
            }
        }

        if (!$canSearch) {
            $response = new Response();
            $response->setSuccess(false);
            $response->setMessage('not-found');

            return $response;
        }

        $query->andWhere(['status' => Gallery::STATUS_ACTIVE]);
        $query->orderBy(['created_at' => SORT_DESC]);

        $countQuery = clone $query;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSizeLimit' => [1, 20],
        ]);

        $galleryList = $query
            ->orderBy(['created_at' => SORT_DESC])
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();

        if (count($galleryList) == 0) {
            $response = new Response();
            $response->setSuccess(false);
            $response->setMessage('not-found');

            return $response;
        }

        foreach ($galleryList as $index => $gallery) {
            $image = GalleryItem::find()->galleryId($gallery['id'])->orderByOrder()->asArray()->one();

            if ($image) {
                $galleryList[$index]['image_url'] = Url::to(($image['base_url'] . '/' . $image['path']), true);
            } else {
                $galleryList[$index]['image_url'] = null;
            }
        }

        $response = new Response();
        $response->setSuccess(true);
        $response->setMessage('found');
        $response->addData('list', $galleryList);
        $response->addData('pages', $pages->pageCount);

        return $response;
    }

}
