<?php

namespace ws\controllers\frontend;

use common\models\domain\Log;
use common\models\web\Response;
use Yii;

/**
 * Log controller
 */
class LogController extends BaseController
{

    protected $accessControlExceptActions = [
        'create'
    ];

    public function actionCreate()
    {
        $r = new Response();

        $data = Yii::$app->request->getRawBody();

        if ($data) {
            $data = json_decode($data, true);

            if ($data) {
                $log = new Log();
                $log->setScenario('create');
                $log->setAttributes($data);

                if ($log->save()) {
                    $r->setSuccess(true);
                } else {
                    $r->setSuccess(false);
                    $r->setMessage('validate');
                    $r->merge($log);
                }
            } else {
                $r->setSuccess(false);
                $r->setMessage('invalid-data');
            }
        } else {
            $r->setSuccess(false);
            $r->setMessage('invalid-data');
        }

        return $r;
    }

}
