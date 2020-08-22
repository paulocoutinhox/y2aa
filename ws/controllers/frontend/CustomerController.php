<?php

namespace ws\controllers\frontend;

use common\models\domain\Customer;
use common\models\web\Response;
use frontend\models\form\LoginForm;
use frontend\models\form\RequestPasswordResetForm;
use frontend\models\form\ResetPasswordForm;
use frontend\models\form\SignUpForm;
use frontend\models\form\SignUpVerificationForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\User;

/**
 * Customer controller
 */
class CustomerController extends BaseController
{

    protected $accessControlExceptActions = [
        'login',
        'signup',
        'avatar',
        'request-password-reset',
        'reset-password',
        'signup-verification',
    ];

    public function actionLogin()
    {
        $data = Yii::$app->request->getRawBody();
        $r = new Response();

        if ($data) {
            $data = json_decode($data, true);

            if ($data) {
                $model = new LoginForm();

                if ($model->load($data, '') && $model->login()) {
                    if (isset(Yii::$app->customer)) {
                        /** @var Customer $customer */
                        $customer = Yii::$app->customer->getIdentity();
                        $token = $customer->getTokenForLogin();

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

    public function actionSignup()
    {
        $data = Yii::$app->request->getRawBody();
        $r = new Response();

        if ($data) {
            $data = json_decode($data, true);

            if ($data) {
                $model = new SignUpForm();

                if (empty($data['languageId'])) {
                    $data['languageId'] = 1;
                }

                if (empty($data['timezone'])) {
                    $data['timezone'] = Yii::$app->params['defaultTimeZone'];
                }

                if ($model->load($data, '') && $customer = $model->signup()) {
                    $token = $customer->getTokenForLogin();

                    $r->setSuccess(true);
                    $r->setMessage('signup-ok');
                    $r->addData('token', (string)$token);
                } else {
                    $r->setSuccess(false);
                    $r->setMessage('signup-fail');
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

    public function actionSignupVerification()
    {
        $data = Yii::$app->request->getRawBody();
        $r = new Response();

        if ($data) {
            $data = json_decode($data, true);

            if ($data) {
                try {
                    $model = new SignUpVerificationForm(($data['token'] ?? null));
                } catch (InvalidArgumentException $e) {
                    throw new BadRequestHttpException($e->getMessage());
                }

                if ($customer = $model->verifyEmail()) {
                    $token = $customer->getTokenForLogin();

                    $r->setSuccess(true);
                    $r->setMessage('verification-ok');
                    $r->addData('token', (string)$token);
                } else {
                    $r->setSuccess(false);
                    $r->setMessage('verification-fail');
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

    public function actionAvatar()
    {
        $id = (int)Yii::$app->request->get('id');
        $customer = Customer::find()->id($id)->one();

        if ($customer) {
            $this->redirect($customer->getAvatar(Yii::getAlias('/images/profile-default.png')));
        } else {
            $this->redirect(Yii::getAlias('/images/profile-default.png'));
        }
    }

    public function actionMyAvatar()
    {
        /** @var Customer $customer */
        $customer = (isset(Yii::$app->customer) ? Yii::$app->customer->getIdentity() : null);

        if ($customer) {
            $this->redirect($customer->getAvatar(Yii::getAlias('/images/profile-default.png')));
        } else {
            $this->redirect(Yii::getAlias('/images/profile-default.png'));
        }
    }

    public function actionRequestPasswordReset()
    {
        $data = Yii::$app->request->getRawBody();
        $r = new Response();

        if ($data) {
            $data = json_decode($data, true);

            if ($data) {
                $model = new RequestPasswordResetForm();

                if ($model->load($data, '') && $model->validate() && $model->sendEmail()) {
                    $r->setSuccess(true);
                    $r->setMessage('request-password-reset-ok');
                } else {
                    $r->setSuccess(false);
                    $r->setMessage('request-password-reset-fail');
                    $r->addDataError('email', Yii::t('common', 'RequestPasswordReset.Error'));
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

    public function actionResetPassword()
    {
        $data = Yii::$app->request->getRawBody();
        $r = new Response();

        if ($data) {
            $data = json_decode($data, true);

            if ($data) {
                $model = new ResetPasswordForm($data['token'] ?? null);

                if ($model->load($data, '') && $model->validate() && $model->resetPassword()) {
                    $r->setSuccess(true);
                    $r->setMessage('reset-password-ok');
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
        /** @var User $customer */
        $user = (Yii::$app->customer ?? null);

        if (!$user->isGuest) {
            /** @var Customer $customer */
            $customer = $user->getIdentity();
            $customer->setScenario('check');
            $customer->avatar = $customer->getAvatar(Yii::$app->params['absoluteURL'] . '/images/profile-default.png', true);

            $response = new Response();
            $response->setSuccess(true);
            $response->setMessage('check-ok');
            $response->addData('customer', $customer->getAttributes($customer->safeAttributes()));
            return $response;
        }

        $response = new Response();
        $response->setSuccess(false);
        $response->setMessage('check-fail');
        return $response;
    }

}
