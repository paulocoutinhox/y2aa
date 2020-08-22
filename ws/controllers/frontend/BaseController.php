<?php

namespace ws\controllers\frontend;

use common\components\jwt\JWTHttpBearerAuth;
use common\models\domain\Customer;
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
                'class' => JWTHttpBearerAuth::class,
                'except' => $this->accessControlExceptActions,
                'only' => $this->accessControlOnlyActions,
                'auth' => function ($token, $authMethod) {
                    $customerId = empty($token->getClaim('id') ? 0 : (int)$token->getClaim('id'));
                    return Customer::find()->id($customerId)->one();
                }
            ],
        ]);
    }

    /*
    public function actionTemplate()
    {
        $data = Yii::$app->request->getRawBody();
        $r = new Response();

        if ($data) {
            $data = json_decode($data, true);

            if ($data) {
                // do operations
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
    */
}
