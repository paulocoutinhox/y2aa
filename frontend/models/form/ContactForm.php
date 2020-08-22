<?php

namespace frontend\models\form;

use Throwable;
use Yii;
use yii\base\Model;

/**
 * Contact form
 */
class ContactForm extends Model
{

    public $name;
    public $email;
    public $subject;
    public $message;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'subject'], 'safe'],
            [['name', 'message', 'email'], 'required'],
            ['email', 'email'],
            ['verifyCode', 'captcha', 'when' => function () {
                return (Yii::$app->params['captchaOnContact'] === true);
            }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('common', 'Model.Name'),
            'email' => Yii::t('common', 'Model.Email'),
            'message' => Yii::t('common', 'Model.Message'),
            'verifyCode' => Yii::t('common', 'Model.VerifyCode'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     * @throws Throwable
     */
    public function sendEmail($email)
    {
        $customer = Yii::$app->user->isGuest ? null : Yii::$app->user->getIdentity();

        $data = [
            'customer' => $customer,
            'name' => $this->name,
            'email' => $this->email,
            'message' => $this->message
        ];

        return Yii::$app->mailer->compose(['html' => 'contact-html', 'text' => 'contact-text'], $data)
            ->setTo($email)
            ->setFrom($email)
            ->setSubject(Yii::t('common', 'Mail.Contact.Subject'))
            ->send();
    }
}
