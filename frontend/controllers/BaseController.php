<?php

namespace frontend\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Base controller
 */
class BaseController extends Controller
{

    protected $accessControlExceptActions = [];
    protected $accessControlOnlyActions = [];
    protected $accessControlRules = [];

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'except' => $this->accessControlExceptActions,
                'only' => $this->accessControlOnlyActions,
                'rules' => $this->accessControlRules,
            ],
        ]);
    }

}
