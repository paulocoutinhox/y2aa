<?php

namespace backend\controllers\reports;

use backend\controllers\ReportController;
use Yii;

/**
 * Customer report controller
 */
class CustomerReportController extends ReportController
{

    protected $model = '\common\models\search\CustomerSearch';

    protected function getContainerClass()
    {
        return 'customer';
    }

    protected function getControllerViewPath()
    {
        return '@backend/views/reports/customer-report';
    }

    protected function getAreaTitle()
    {
        return Yii::t('backend', 'CustomerReport.Area.Title');
    }

    protected function createDataProvider(&$model)
    {
        $dataProvider = parent::createDataProvider($model);
        $dataProvider->setPagination(false);
        return $dataProvider;
    }

}