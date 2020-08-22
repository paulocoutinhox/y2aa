<?php

namespace backend\controllers;

use Yii;

/**
 * PreferenceController implements the CRUD actions for Preference model
 */
class PreferenceController extends CRUDController
{

    protected $modelForSearch = '\common\models\search\PreferenceSearch';
    protected $modelForView = '\common\models\domain\Preference';
    protected $modelForCreate = '\common\models\domain\Preference';
    protected $modelForUpdate = '\common\models\domain\Preference';
    protected $modelForDelete = '\common\models\domain\Preference';

    protected function getContainerClass()
    {
        return 'preference';
    }

    protected function getControllerViewPath()
    {
        return '@backend/views/preference';
    }

    protected function getAreaTitle()
    {
        return Yii::t('backend', 'Preference.Area.Title');
    }

    public function actionCreate()
    {
        Yii::$app->getResponse()->redirect(['preference/index']);
        Yii::$app->end();
    }

    public function actionDelete()
    {
        Yii::$app->getResponse()->redirect(['preference/index']);
        Yii::$app->end();
    }

    protected function beforeRenderOnIndex()
    {
        parent::beforeRenderOnIndex();
        $this->addRenderParam('showCreateButton', false);
    }

}
