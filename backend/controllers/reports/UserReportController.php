<?php

namespace backend\controllers\reports;

use backend\controllers\ReportController;
use Yii;

/**
 * User report controller
 */
class UserReportController extends ReportController
{

    protected $model = '\common\models\search\UserSearch';

    protected function getContainerClass()
    {
        return 'user';
    }

    protected function getControllerViewPath()
    {
        return '@backend/views/reports/user-report';
    }

    protected function getAreaTitle()
    {
        return Yii::t('backend', 'UserReport.Area.Title');
    }

    protected function createDataProvider(&$model)
    {
        $dataProvider = parent::createDataProvider($model);
        $dataProvider->setPagination(false);
        return $dataProvider;
    }

}