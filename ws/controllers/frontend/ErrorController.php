<?php

namespace ws\controllers\frontend;

use yii\web\Controller;

/**
 * Error controller
 */
class ErrorController extends Controller
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

}
