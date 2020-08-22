<?php

namespace frontend\models\form;

use common\models\domain\Customer;
use Yii;
use yii\base\Model;

class LoginForm extends Model
{

    public $email;
    public $password;
    public $rememberMe = true;
    public $verifyCode;

    private $_customer;

    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],

            ['password', 'required'],
            ['password', 'validatePassword'],

            ['rememberMe', 'boolean'],
            
            ['verifyCode', 'captcha', 'when' => function () {
                return (Yii::$app->params['captchaOnLogin'] === true);
            }],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $customer = $this->getCustomer();

            if (!$customer || !$customer->validatePassword($this->password)) {
                $this->addError($attribute, Yii::t('common', 'Error.Login.IncorrectEmailPassword'));
            } else if ($customer->status != Customer::STATUS_ACTIVE) {
                $this->addError($attribute, Yii::t('common', 'Error.Login.CustomerNotActive'));
            }
        }
    }

    /**
     * Finds customer by email
     *
     * @return Customer|null
     */
    protected function getCustomer()
    {
        if ($this->_customer === null) {
            $this->_customer = Customer::findByEmail($this->email);
        }

        return $this->_customer;
    }

    /**
     * Logs in a user using the provided username and password
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $customer = $this->getCustomer();
            $result = Yii::$app->user->login($customer, $this->rememberMe ? 3600 * 24 * 30 : 0);

            if ($result) {
                $customer->doAfterLogin();
            }

            return $result;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('common', 'Model.Email'),
            'password' => Yii::t('common', 'Model.Password'),
            'rememberMe' => Yii::t('common', 'Model.RememberMe'),
            'verifyCode' => Yii::t('common', 'Model.VerifyCode'),
        ];
    }

}
