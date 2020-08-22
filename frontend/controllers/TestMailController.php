<?php

namespace frontend\controllers;

use frontend\models\form\ContactForm;
use Throwable;
use Yii;
use yii\base\ExitException;

/**
 * Test mail controller
 */
class TestMailController extends BaseController
{

    protected $accessControlRules = [
        [
            'allow' => true,
            'roles' => ['@'],
        ],
    ];

    /**
     * @throws Throwable
     * @throws ExitException
     */
    public function actionContact()
    {
        $to = Yii::$app->request->get('to');

        $model = new ContactForm();
        $model->name = "My Name";
        $model->email = "custom@email.com";
        $model->message = "This is a test message\nfrom contact form.\n\nYou are receiving it because you are the administrator.";
        $sent = $model->sendEmail($to);

        if ($sent) {
            echo('OK');
        } else {
            echo('ERROR');
        }

        Yii::$app->end();
    }

}
