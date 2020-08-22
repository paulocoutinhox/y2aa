<?php

namespace backend\controllers;

use common\models\domain\User;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * UserController implements the CRUD actions for User model
 */
class UserController extends CRUDController
{

    protected $modelForSearch = '\common\models\search\UserSearch';
    protected $modelForView = '\common\models\domain\User';
    protected $modelForCreate = '\common\models\domain\User';
    protected $modelForUpdate = '\common\models\domain\User';
    protected $modelForDelete = '\common\models\domain\User';

    protected function getContainerClass()
    {
        return 'user';
    }

    protected function getControllerViewPath()
    {
        return '@backend/views/user';
    }

    protected function getAreaTitle()
    {
        return Yii::t('backend', 'User.Area.Title');
    }

    protected function afterModelNewInstanceOnCreate(&$model)
    {
        parent::afterModelNewInstanceOnCreate($model);
        $model->timezone = 'America/Sao_Paulo';
        $model->root = User::ROOT_NO;
    }

    protected function afterValidateOnCreate(&$model)
    {
        if ($model->password) {
            $model->setPassword($model->password);
        }

        return parent::afterValidateOnCreate($model);
    }

    protected function afterValidateOnUpdate(&$model)
    {
        if ($model->password) {
            $model->setPassword($model->password);
        }

        return parent::afterValidateOnUpdate($model);
    }

    protected function getModelForUpdate()
    {
        $model = parent::getModelForUpdate();

        if ($model) {
            if (!Yii::$app->request->isPost) {
                $model->groups = ArrayHelper::map($model->getGroups()->asArray()->all(), 'id', 'id');
            }
        }

        return $model;
    }

    protected function getModelForView()
    {
        $model = parent::getModelForView();

        if ($model) {
            $model->groups = ArrayHelper::map($model->getGroups()->asArray()->all(), 'id', 'id');
        }

        return $model;
    }

}