<?php

namespace backend\controllers;

use backend\models\form\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Cookie;

/**
 * SiteController has the basic actions
 */
class SiteController extends BaseController
{

    protected $accessControlExceptActions = ['login', 'logout'];

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get'],
                    'login' => ['get', 'post'],
                    'logout' => ['get', 'post'],
                    'set-sidebar-menu-state' => ['get'],
                ],
            ]
        ]);
    }

    /**
     * Displays home/dashboard
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = 'base';

        if (!Yii::$app->user->isGuest) {
            return $this->redirect('@web/site/index');
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Set sidebar menu state
     */
    public function actionSetSidebarMenuState($state)
    {
        $allowed = ['closed', 'opened'];

        if (in_array($state, $allowed)) {
            $cookie = new Cookie([
                'name' => 'admin-toggle-sidebar-state',
                'value' => $state,
                'expire' => time() + 86400 * 365,
            ]);

            $cookies = Yii::$app->response->cookies;
            $cookies->add($cookie);
        }

        return null;
    }

}
