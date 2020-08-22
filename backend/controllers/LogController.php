<?php

namespace backend\controllers;

use Yii;

/**
 * LogController implements the CRUD actions for Log model
 */
class LogController extends CRUDController
{

    protected $modelForSearch = '\common\models\search\LogSearch';
    protected $modelForView = '\common\models\domain\Log';
    protected $modelForCreate = '\common\models\domain\Log';
    protected $modelForUpdate = '\common\models\domain\Log';
    protected $modelForDelete = '\common\models\domain\Log';

    protected function getContainerClass()
    {
        return 'log';
    }

    protected function getControllerViewPath()
    {
        return '@backend/views/log';
    }

    protected function getAreaTitle()
    {
        return Yii::t('backend', 'Log.Area.Title');
    }

    protected function beforeRenderOnIndex()
    {
        parent::beforeRenderOnIndex();
        $this->addRenderParam('showCreateButton', false);
    }

    public function actionCreate()
    {
        Yii::$app->getResponse()->redirect(['log/index']);
        Yii::$app->end();
    }

    public function actionUpdate()
    {
        Yii::$app->getResponse()->redirect(['log/index']);
        Yii::$app->end();
    }

    protected function setupSearchSortData(&$dataProvider)
    {
        parent::setupSearchSortData($dataProvider);

        $dataProvider->sort->attributes['customer.name'] = [
            'asc' => ['customer.name' => SORT_ASC],
            'desc' => ['customer.name' => SORT_DESC],
            'default' => SORT_ASC
        ];
    }

    protected function createDataProvider(&$model)
    {
        $dataProvider = parent::createDataProvider($model);
        $dataProvider->pagination = ['pageSize' => 100];
        return $dataProvider;
    }

}
