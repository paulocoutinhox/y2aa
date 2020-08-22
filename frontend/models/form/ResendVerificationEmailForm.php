<?php

namespace frontend\models\form;

use common\models\domain\Customer;
use Yii;
use yii\base\Model;

/**
 * Resend verification email form
 */
class ResendVerificationEmailForm extends Model
{

    public $email;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'string', 'max' => 255],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\domain\Customer',
                'filter' => ['status' => Customer::STATUS_INACTIVE],
                'message' => Yii::t('common', 'Error.Customer.ResendVerificationEmail.EmailNotFound'),
            ],
            ['verifyCode', 'captcha', 'when' => function () {
                return (Yii::$app->params['captchaOnResendVerificationEmail'] === true);
            }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('common', 'Model.Email'),
            'verifyCode' => Yii::t('common', 'Model.VerifyCode'),
        ];
    }

    /**
     * Sends confirmation email to customer
     * @return bool whether the email was sent
     */
    public function sendEmail()
    {
        $customer = Customer::findOne([
            'email' => $this->email,
            'status' => Customer::STATUS_INACTIVE
        ]);

        if ($customer === null) {
            return false;
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'signupVerification-html', 'text' => 'signupVerification-text'],
                ['customer' => $customer]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setTo($this->email)
            ->setSubject(Yii::t('common', 'Mail.SignUpVerification.Subject', ['name' => Yii::$app->name]))
            ->send();
    }

}
