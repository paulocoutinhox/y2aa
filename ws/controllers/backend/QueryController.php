<?php

namespace ws\controllers\backend;

use common\models\domain\Query;
use common\models\web\Response;
use Exception;
use Yii;

/**
 * Query controller
 */
class QueryController extends BaseController
{

    public function actionExecute()
    {
        $r = new Response();

        $data = Yii::$app->request->getRawBody();

        if ($data) {
            $data = json_decode($data, true);

            if ($data) {
                $model = new Query();

                if ($model->load($data, '')) {
                    $result = null;

                    try {
                        if ($model->type == Query::QUERY_TYPE_SElECT) {
                            $result = Yii::$app->db->createCommand($model->query)->queryAll();

                            $r->setSuccess(true);
                            $r->addData('amount', count($result));
                            $r->addData('rows', $result);
                        } else {
                            $result = Yii::$app->db->createCommand($model->query)->execute();

                            $r->setSuccess(true);
                            $r->addData('affected', $result);
                        }
                    } catch (Exception $e) {
                        $r->setSuccess(false);
                        $r->addDataError('query', $e->getMessage());
                    }
                } else {
                    $r->setSuccess(false);
                    $r->setMessage('login-fail');
                    $r->merge($model);
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
