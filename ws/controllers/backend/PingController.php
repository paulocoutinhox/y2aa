<?php

namespace ws\controllers\backend;

use common\models\web\Response;

/**
 * Ping controller
 */
class PingController extends BaseController
{

    protected $accessControlExceptActions = ['index'];

    public function actionIndex()
    {
        $r = new Response();
        $r->setSuccess(true);
        $r->setMessage('pong');
        return $r;
    }

}
