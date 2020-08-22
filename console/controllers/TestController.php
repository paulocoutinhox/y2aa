<?php

namespace console\controllers;

use common\models\util\Logger;
use yii\console\Controller;

class TestController extends Controller
{

    public function actionTest()
    {
        Logger::s('DONE');
    }

}