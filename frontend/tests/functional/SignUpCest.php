<?php

namespace frontend\tests\functional;

use common\models\domain\Customer;
use frontend\tests\FunctionalTester;

class SignUpCest
{
    protected $formId = '#form-signup';


    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('customer/signup');
    }

    public function signupWithEmptyFields(FunctionalTester $I)
    {
        $I->see('SignUp', 'h1');
        $I->see('Please fill out the following fields to signup:');
        $I->submitForm($this->formId, []);
        $I->seeValidationError('Email cannot be blank.');
        $I->seeValidationError('Password cannot be blank.');

    }

    public function signupWithWrongEmail(FunctionalTester $I)
    {
        $I->submitForm(
            $this->formId, [
                'SignUpForm[email]' => 'ttttt',
                'SignUpForm[password]' => 'tester_password',
            ]
        );
        $I->dontSee('Email cannot be blank.', '.help-block');
        $I->dontSee('Password cannot be blank.', '.help-block');
        $I->see('Email is not a valid email address.', '.help-block');
    }

    public function signupSuccessfully(FunctionalTester $I)
    {
        $I->submitForm($this->formId, [
            'SignUpForm[email]' => 'tester.email@example.com',
            'SignUpForm[password]' => 'tester_password',
        ]);

        $I->seeRecord('common\models\domain\Customer', [
            'email' => 'tester.email@example.com',
            'status' => Customer::STATUS_INACTIVE
        ]);

        $I->seeEmailIsSent();
        $I->see('Thank you for registration. Please check your inbox for verification email.');
    }
}
