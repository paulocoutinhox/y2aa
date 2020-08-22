<?php

namespace ws\controllers\frontend;

use common\models\web\Response;

/**
 * Ping controller
 */
class PingController extends BaseController
{

    protected $accessControlExceptActions = ['index'];

    public function actionIndex()
    {
        $response = new Response();
        $response->setSuccess(true);
        $response->setMessage('pong');
        return $response;
    }

}
