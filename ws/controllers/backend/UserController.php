<?php

namespace ws\controllers\backend;

use backend\models\form\LoginForm;
use common\models\domain\User;
use common\models\web\Response;
use Yii;

/**
 * User controller
 */
class UserController extends BaseController
{

    protected $accessControlExceptActions = [
        'login',
    ];

    public function actionLogin()
    {
        $r = new Response();

        $data = Yii::$app->request->getRawBody();

        if ($data) {
            $data = json_decode($data, true);

            if ($data) {
                $model = new LoginForm();

                if ($model->load($data, '') && $model->login()) {
                    if (isset(Yii::$app->user)) {
                        /** @var User $user */
                        $user = Yii::$app->user->getIdentity();
                        $token = $user->getTokenForLogin();

                        $r->setSuccess(true);
                        $r->setMessage('login-ok');
                        $r->addData('token', (string)$token);
                    } else {
                        $r->setSuccess(false);
                        $r->setMessage('login-fail');
                        $r->merge($model);
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

    public function actionCheck()
    {
        $r = new Response();

        $appUser = Yii::$app->user;

        if (!$appUser->isGuest) {
            /** @var User $user */
            $user = $appUser->getIdentity();
            $user->setScenario('check');
            $user->avatar = $user->getAvatar(Yii::$app->params['absoluteURL'] . '/admin/images/profile-default.png', true);

            $r->setSuccess(true);
            $r->setMessage('check-ok');
            $r->addData('user', $user->getAttributes($user->safeAttributes()));
        } else {
            $r = new Response();
            $r->setSuccess(false);
            $r->setMessage('check-fail');
        }

        return $r;
    }

}
