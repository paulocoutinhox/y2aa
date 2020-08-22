<?php

namespace backend\controllers;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * GroupController implements the CRUD actions for Group model
 */
class GroupController extends CRUDController
{

    protected $modelForSearch = '\common\models\search\GroupSearch';
    protected $modelForView = '\common\models\domain\Group';
    protected $modelForCreate = '\common\models\domain\Group';
    protected $modelForUpdate = '\common\models\domain\Group';
    protected $modelForDelete = '\common\models\domain\Group';

    protected function getContainerClass()
    {
        return 'group';
    }

    protected function getControllerViewPath()
    {
        return '@backend/views/group';
    }

    protected function getAreaTitle()
    {
        return Yii::t('backend', 'Group.Area.Title');
    }

    protected function getModelForUpdate()
    {
        $model = parent::getModelForUpdate();

        if ($model) {
            if (!Yii::$app->request->isPost) {
                $model->permissions = ArrayHelper::map($model->getPermissions()->asArray()->all(), 'id', 'id');
            }
        }

        return $model;
    }

    protected function getModelForView()
    {
        $model = parent::getModelForView();

        if ($model) {
            $model->permissions = ArrayHelper::map($model->getPermissions()->asArray()->all(), 'id', 'id');
        }

        return $model;
    }

}
