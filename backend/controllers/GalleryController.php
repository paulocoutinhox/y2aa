<?php

namespace backend\controllers;

use Intervention\Image\ImageManagerStatic;
use League\Flysystem\File;
use trntv\filekit\actions\DeleteAction;
use trntv\filekit\actions\UploadAction;
use Yii;

/**
 * GalleryController implements the CRUD actions for Gallery model
 */
class GalleryController extends CRUDController
{

    protected $modelForSearch = '\common\models\search\GallerySearch';
    protected $modelForView = '\common\models\domain\Gallery';
    protected $modelForCreate = '\common\models\domain\Gallery';
    protected $modelForUpdate = '\common\models\domain\Gallery';
    protected $modelForDelete = '\common\models\domain\Gallery';

    public function actions()
    {
        return [
            'item-upload' => [
                'class' => UploadAction::class,
                'deleteRoute' => 'item-delete',
                'fileStorage' => 'galleryFileStorage',
                'on afterSave' => function ($event) {
                    /* @var $file File */
                    $file = $event->file;

                    $img = ImageManagerStatic::make($file->read())->resize(null, 600, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $file->put($img->encode());
                }
            ],
            'item-delete' => [
                'class' => DeleteAction::class,
                'fileStorage' => 'galleryFileStorage',
            ]
        ];
    }

    protected function getContainerClass()
    {
        return 'gallery';
    }

    protected function getControllerViewPath()
    {
        return '@backend/views/gallery';
    }

    protected function getAreaTitle()
    {
        return Yii::t('backend', 'Gallery.Area.Title');
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
