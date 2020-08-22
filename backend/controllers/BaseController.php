<?php

namespace backend\controllers;

use backend\filters\AccessControl;
use yii\web\Controller;

/**
 * Base controller
 */
class BaseController extends Controller
{

    protected $accessControlExceptActions = [];

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'except' => $this->accessControlExceptActions,
            ],
        ]);
    }

}
