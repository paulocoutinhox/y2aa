<?php

namespace backend\controllers;

use vova07\imperavi\actions\GetImagesAction;
use vova07\imperavi\actions\UploadFileAction;
use Yii;
use yii\helpers\Url;

/**
 * ContentController implements the CRUD actions for Content model
 */
class ContentController extends CRUDController
{

    protected $modelForSearch = '\common\models\search\ContentSearch';
    protected $modelForView = '\common\models\domain\Content';
    protected $modelForCreate = '\common\models\domain\Content';
    protected $modelForUpdate = '\common\models\domain\Content';
    protected $modelForDelete = '\common\models\domain\Content';

    public function actions()
    {
        return [
            'get-images' => [
                'class' => GetImagesAction::class,
                'url' => Url::to('/uploads/general'),
                'path' => Yii::getAlias('@root/uploads/general'),
                'options' => [
                    'only' => ['*.jpg', '*.png', '*.jpeg']
                ]
            ],
            'upload-image' => [
                'class' => UploadFileAction::class,
                'url' => Url::to('/uploads/general'),
                'path' => Yii::getAlias('@root/uploads/general'),
            ],
        ];
    }

    protected function getContainerClass()
    {
        return 'content';
    }

    protected function getControllerViewPath()
    {
        return '@backend/views/content';
    }

    protected function getAreaTitle()
    {
        return Yii::t('backend', 'Content.Area.Title');
    }

    protected function setupSearchSortData(&$dataProvider)
    {
        parent::setupSearchSortData($dataProvider);

        $dataProvider->sort->attributes['language.name'] = [
            'asc' => ['language.name' => SORT_ASC],
            'desc' => ['language.name' => SORT_DESC],
            'default' => SORT_ASC
        ];
    }

}
