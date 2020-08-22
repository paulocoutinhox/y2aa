<?php

namespace backend\models\form;

use common\models\domain\User;
use Yii;
use yii\base\Model;

class LoginForm extends Model
{

    public $email;
    public $password;
    public $rememberMe = true;

    private $_user;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
            ['email', 'email'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, Yii::t('common', 'Error.Login.IncorrectEmailPassword'));
            } else if ($user->status != User::STATUS_ACTIVE) {
                $this->addError($attribute, Yii::t('common', 'Error.Login.UserNotActive'));
            }
        }
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }

    /**
     * Logs in a user using the provided email and password
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
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
        ];
    }

}
