<?php

namespace frontend\tests\functional;

use common\models\domain\Customer;
use frontend\fixtures\CustomerFixture;
use frontend\tests\FunctionalTester;

class VerifyEmailCest
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
                'dataFile' => codecept_data_dir() . 'customer.php',
            ],
        ];
    }

    public function checkEmptyToken(FunctionalTester $I)
    {
        $I->amOnRoute('site/verify-email', ['token' => '']);
        $I->canSee('Bad Request', 'h1');
        $I->canSee('Verify email token cannot be blank.');
    }

    public function checkInvalidToken(FunctionalTester $I)
    {
        $I->amOnRoute('site/verify-email', ['token' => 'wrong_token']);
        $I->canSee('Bad Request', 'h1');
        $I->canSee('Wrong verify email token.');
    }

    public function checkNoToken(FunctionalTester $I)
    {
        $I->amOnRoute('site/verify-email');
        $I->canSee('Bad Request', 'h1');
        $I->canSee('Missing required parameters: token');
    }

    public function checkAlreadyActivatedToken(FunctionalTester $I)
    {
        $I->amOnRoute('site/verify-email', ['token' => 'already_used_token_1548675330']);
        $I->canSee('Bad Request', 'h1');
        $I->canSee('Wrong verify email token.');
    }

    public function checkSuccessVerification(FunctionalTester $I)
    {
        $I->amOnRoute('site/verify-email', ['token' => '4ch0qbfhvWwkcuWqjN8SWRq72SOw1KYT_1548675330']);
        $I->canSee('Your email has been confirmed!');
        $I->canSee('Congratulations!', 'h1');
        $I->see('Logout (test.test)', 'form button[type=submit]');

        $I->seeRecord('common\models\domain\Customer', [
            'email' => 'test@mail.com',
            'status' => Customer::STATUS_ACTIVE
        ]);
    }
}
