<?php

namespace frontend\controllers;

use Mobile_Detect;

/**
 * Download controller
 */
class DownloadController extends BaseController
{

    protected $accessControlExceptActions = ['index'];

    public function actionIndex()
    {
        $mobileDetect = new Mobile_Detect();

        $system = null;

        if ($mobileDetect->is('iOS')) {
            $system = 'ios';
        } else if ($mobileDetect->is('AndroidOS')) {
            $system = 'android';
        }

        return $this->render('index', [
            'system' => $system
        ]);
    }

}
