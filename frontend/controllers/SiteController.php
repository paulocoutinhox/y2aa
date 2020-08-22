<?php

namespace frontend\controllers;

/**
 * Site controller
 */
class SiteController extends BaseController
{

    protected $accessControlExceptActions = ['index', 'error', 'captcha'];

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', []);
    }

}
