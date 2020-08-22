<?php

namespace ws\controllers\backend;

use common\components\jwt\JWTHttpBearerAuth;
use common\models\domain\User;
use yii\web\Controller;

/**
 * Admin controller
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
                    $userId = empty($token->getClaim('id') ? 0 : (int)$token->getClaim('id'));
                    return User::find()->id($userId)->one();
                }
            ],
        ]);
    }

    public function actionIndex()
    {
        return 'OK';
    }

}
