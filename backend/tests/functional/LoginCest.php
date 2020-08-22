<?php

namespace backend\tests\functional;

use backend\fixtures\UserFixture;
use backend\tests\FunctionalTester;
use Yii;

/**
 * Class LoginCest
 */
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
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'login.php'
            ]
        ];
    }

    public function _before(FunctionalTester $I)
    {
        Yii::$app->language = 'en';
    }

    /**
     * @param FunctionalTester $I
     */
    public function loginUser(FunctionalTester $I)
    {
        $I->amOnPage('/admin');

        $I->fillField(['name' => 'LoginForm[email]'], 'paulo@prsolucoes.com');
        $I->fillField(['name' => 'LoginForm[password]'], 'webmaster@password');
        $I->click('#login-form button[type=submit]');

        $I->see('Logout');
    }

}
