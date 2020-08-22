<?php

namespace backend\controllers;

use Yii;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\db\ActiveRecord;
use yii\filters\VerbFilter;

/**
 * Report controller
 */
class ReportController extends BaseController
{

    /**
     * It was passed as param, so all methods can add data here to be accessed from view
     * @var array
     */
    protected $renderParams = [];

    /**
     * @var ActiveRecord
     */
    protected $model = null;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get', 'post'],
                ],
            ]
        ]);
    }

    public function actionIndex()
    {
        // init
        $model = $this->getModelForIndex();
        $dataProvider = $this->createDataProvider($model);
        $areaTitle = $this->getAreaTitle();

        // setup sort
        $this->setupSearchSortData($dataProvider);

        // default params
        $this->addRenderParam('title', Yii::t('backend', 'Common.Area.Report.Title', ['areaTitle' => $areaTitle]));
        $this->addRenderParam('areaTitle', $areaTitle);
        $this->addRenderParam('breadcrumbs', [Yii::t('backend', 'Common.Area.Report.Breadcrumb.Title', ['areaTitle' => $areaTitle])]);
        $this->addRenderParam('containerClass', $this->getContainerClass());
        $this->addRenderParam('viewPath', $this->getControllerViewPath());
        $this->addRenderParam('model', $model);
        $this->addRenderParam('filterModel', $model);
        $this->addRenderParam('dataProvider', $dataProvider);

        // render
        $this->beforeRenderOnIndex();

        return $this->render('@backend/views/shared/report/index', $this->renderParams);
    }

    /**
     * Get the model for index action
     * @return ActiveRecord
     */
    protected function getModelForIndex()
    {
        $model = new $this->model;
        return $model;
    }

    /**
     * Get the data provider
     * @param $model
     * @return mixed
     * @see ActiveDataProvider, SqlDataProvider, ArrayDataProvider
     */
    protected function createDataProvider(&$model)
    {
        return $model->search(Yii::$app->request->queryParams);
    }

    /**
     * Get custom area title
     * @throws Exception
     */
    protected function getAreaTitle()
    {
        throw new Exception('You need set it on your own class.');
    }

    /**
     * Setup data provider with sort data
     * @param $dataProvider
     */
    protected function setupSearchSortData(&$dataProvider)
    {
        $dataProvider->sort = [
            'defaultOrder' => $this->getSearchDefaultSort()
        ];
    }

    /**
     * Get the default search sort data
     * @return array
     */
    protected function getSearchDefaultSort()
    {
        return ['id' => SORT_DESC];
    }

    /**
     * Add new data to render params
     * @param $key
     * @param $value
     */
    protected function addRenderParam($key, $value)
    {
        if ($this->renderParams == null) {
            $this->renderParams = [];
        }

        $this->renderParams[$key] = $value;
    }

    /**
     * Get custom CSS class for the view containers
     * @throws Exception
     */
    protected function getContainerClass()
    {
        throw new Exception('You need set it on your own class.');
    }

    /**
     * Get custom view path for child controller
     * @throws Exception
     */
    protected function getControllerViewPath()
    {
        throw new Exception('You need set it on your own class.');
    }

    /**
     * Execute before call render on index action
     */
    protected function beforeRenderOnIndex()
    {
    }

}
