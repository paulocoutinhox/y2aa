<?php

namespace frontend\models\form;

use common\models\domain\Customer;
use Yii;
use yii\base\Exception;
use yii\base\Model;

/**
 * Request password reset form
 */
class RequestPasswordResetForm extends Model
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
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\domain\Customer',
                'filter' => ['status' => Customer::STATUS_ACTIVE],
                'message' => Yii::t('common', 'Error.Customer.RequestPasswordReset.EmailNotFound')
            ],
            ['verifyCode', 'captcha', 'when' => function () {
                return (Yii::$app->params['captchaOnRequestPasswordReset'] === true);
            }],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password
     *
     * @return bool whether the email was send
     * @throws Exception
     */
    public function sendEmail()
    {
        $customer = Customer::findOne([
            'status' => Customer::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$customer) {
            return false;
        }

        if (!Customer::isPasswordResetTokenValid($customer->password_reset_token)) {
            $customer->generatePasswordResetToken();

            if (!$customer->save()) {
                return false;
            }
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'customerPasswordResetToken-html', 'text' => 'customerPasswordResetToken-text'],
                ['customer' => $customer]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject(Yii::t('common', 'Mail.CustomerRequestPasswordReset.Subject', ['name' => $customer->name]))
            ->send();
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

}
