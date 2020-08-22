<?php

namespace frontend\tests\functional;

use frontend\fixtures\CustomerFixture;
use frontend\tests\FunctionalTester;

class LoginCest
{
    /**
     * Load fixtures before db transaction begin
     * Called in _before()
     * @return array
     * @see \Codeception\Module\Yii2::loadFixtures()
     * @see \Codeception\Module\Yii2::_before()
     */
    public function _fixtures()
    {
        return [
            'customer' => [
                'class' => CustomerFixture::class,
                'dataFile' => codecept_data_dir() . 'login.php',
            ],
        ];
    }

    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
    }

    protected function formParams($login, $password)
    {
        return [
            'LoginForm[email]' => $login,
            'LoginForm[password]' => $password,
            'LoginForm[verifyCode]' => 'testme',
        ];
    }

    public function checkEmpty(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('', ''));
        $I->seeValidationError('Email cannot be blank.');
        $I->seeValidationError('Password cannot be blank.');
    }

    public function checkWrongPassword(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('wrong@prsolucoes.com', 'wrong'));
        $I->seeValidationError('Invalid email or password.');
    }

    public function checkInactiveAccount(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('inactive@prsolucoes.com', 'customer@password'));
        $I->seeValidationError('Invalid email or password.');
    }

    public function checkValidLogin(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('paulo@prsolucoes.com', 'customer@password'));
        $I->see('Logout', 'form button[type=submit]');
        $I->dontSeeLink('Login');
        $I->dontSeeLink('SignUp');
    }
}
