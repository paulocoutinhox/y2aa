<?php

namespace frontend\controllers;

use common\models\domain\Customer;
use common\models\web\Response;
use frontend\models\form\LoginForm;
use frontend\models\form\RequestPasswordResetForm;
use frontend\models\form\ResendVerificationEmailForm;
use frontend\models\form\ResetPasswordForm;
use frontend\models\form\SignUpForm;
use frontend\models\form\SignUpVerificationForm;
use Intervention\Image\ImageManagerStatic;
use League\Flysystem\File;
use Throwable;
use trntv\filekit\actions\DeleteAction;
use trntv\filekit\actions\UploadAction;
use Yii;
use yii\base\Exception;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;

/**
 * Customer controller
 */
class CustomerController extends BaseController
{

    protected $accessControlRules = [
        [
            'actions' => ['login', 'signup', 'request-password-reset', 'reset-password', 'signup-success', 'signup-verification', 'resend-verification-email'],
            'allow' => true,
        ],
        [
            'actions' => ['logout', 'profile', 'update', 'update-password', 'update-image', 'avatar-upload', 'avatar-delete'],
            'allow' => true,
            'roles' => ['@'],
        ],
    ];

    protected $accessControlExceptActions = ['check'];

    public function actions()
    {
        return [
            'avatar-upload' => [
                'class' => UploadAction::class,
                'deleteRoute' => 'avatar-delete',
                'fileStorage' => 'customerProfileFileStorage',
                'on afterSave' => function ($event) {
                    /* @var $file File */
                    $file = $event->file;
                    $img = ImageManagerStatic::make($file->read())->fit(1024, 1024);
                    $file->put($img->encode());
                }
            ],
            'avatar-delete' => [
                'class' => DeleteAction::class,
                'fileStorage' => 'customerProfileFileStorage',
            ]
        ];
    }

    /**
     * Logs in a customer
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render($this->action->id, [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Signs user up
     *
     * @return mixed
     * @throws Exception
     */
    public function actionSignup()
    {
        $model = new SignUpForm();

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            return $this->redirect(['/customer/signup-success']);
        } else {
            $model->timezone = Yii::$app->params['defaultTimeZone'];
            $model->languageId = 1;
        }

        return $this->render($this->action->id, [
            'model' => $model,
        ]);
    }

    public function actionSignupSuccess()
    {
        return $this->render($this->action->id, []);
    }

    /**
     * Requests password reset
     *
     * @return mixed
     * @throws Exception
     */
    public function actionRequestPasswordReset()
    {
        $model = new RequestPasswordResetForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', Yii::t('frontend', 'Message.RequestPasswordReset.Success'));
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', Yii::t('frontend', 'Error.RequestPasswordResetFailed'));
            }
        }

        return $this->render($this->action->id, [
            'model' => $model,
        ]);
    }

    /**
     * Resets password
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     * @throws Exception
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', Yii::t('frontend', 'Message.Customer.ResetPassword.Success'));
            return $this->goHome();
        }

        return $this->render($this->action->id, [
            'model' => $model,
        ]);
    }

    /**
     * Profile
     */
    public function actionProfile()
    {
        return $this->render($this->action->id, []);
    }

    /**
     * Update profile
     *
     * @return mixed
     */
    public function actionUpdate()
    {
        /** @var Customer $model */
        $model = Yii::$app->user->identity;
        $model->setScenario('update-profile');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('frontend', 'Message.Customer.UpdateProfile.Success'));
                return $this->redirect(['/customer/profile']);
            }
        }

        return $this->render($this->action->id, [
            'model' => $model,
        ]);
    }

    /**
     * Update password
     *
     * @return mixed
     * @throws Exception
     */
    public function actionUpdatePassword()
    {
        /** @var Customer $model */
        $model = Yii::$app->user->identity;
        $model->setScenario('update-password');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->setPassword($model->password);
            $model->removePasswordResetToken();

            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('frontend', 'Message.Customer.UpdatePassword.Success'));
                return $this->redirect(['/customer/profile']);
            }
        }

        return $this->render($this->action->id, [
            'model' => $model,
        ]);
    }

    /**
     * Update image
     *
     * @return mixed
     */
    public function actionUpdateImage()
    {
        /** @var Customer $model */
        $model = Yii::$app->user->identity;
        $model->setScenario('update-image');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('frontend', 'Message.Customer.UpdateImage.Success'));
                return $this->redirect(['/customer/profile']);
            }
        }

        return $this->render($this->action->id, [
            'model' => $model,
        ]);
    }

    /**
     * Check user and return their data
     *
     * @return string
     */
    public function actionCheck()
    {
        $customer = Yii::$app->user;

        if (!$customer->isGuest) {
            /** @var Customer $customer */
            $customer = $customer->getIdentity();
            $customer->setScenario('check');
            $customer->avatar = Yii::$app->urlManager->createAbsoluteUrl($customer->getAvatar(Yii::getAlias('/images/profile-default.png')), true);

            $response = new Response();
            $response->setSuccess(true);
            $response->setMessage('check-ok');

            $responseData = $customer->getAttributes($customer->safeAttributes());

            $response->addData('customer', $responseData);
            return $response;
        }

        $response = new Response();
        $response->setSuccess(false);
        $response->setMessage('check-fail');
        return $response;
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @return yii\web\Response
     * @throws BadRequestHttpException
     * @throws Throwable
     */
    public function actionSignupVerification($token)
    {
        try {
            $model = new SignUpVerificationForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($customer = $model->verifyEmail()) {
            if (Yii::$app->user->login($customer)) {
                Yii::$app->session->setFlash('success', Yii::t('frontend', 'Message.SignUp.Verification.Success'));
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', Yii::t('frontend', 'Error.SignUp.VerificationFailed'));
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', Yii::t('common', 'Message.Customer.ResendVerificationEmail.Success'));
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', Yii::t('common', 'Error.Customer.ResendVerificationEmail'));
            }
        }

        return $this->render($this->action->id, [
            'model' => $model,
        ]);
    }

}
