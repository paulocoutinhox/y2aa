<?php

namespace backend\controllers;

use Yii;

/**
 * CustomerController implements the CRUD actions for Customer model
 */
class CustomerController extends CRUDController
{

    protected $modelForSearch = '\common\models\search\CustomerSearch';
    protected $modelForView = '\common\models\domain\Customer';
    protected $modelForCreate = '\common\models\domain\Customer';
    protected $modelForUpdate = '\common\models\domain\Customer';
    protected $modelForDelete = '\common\models\domain\Customer';

    protected function getContainerClass()
    {
        return 'customer';
    }

    protected function getControllerViewPath()
    {
        return '@backend/views/customer';
    }

    protected function getAreaTitle()
    {
        return Yii::t('backend', 'Customer.Area.Title');
    }

    protected function afterModelNewInstanceOnCreate(&$model)
    {
        parent::afterModelNewInstanceOnCreate($model);
        $model->timezone = Yii::$app->params['defaultTimeZone'];
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

}
