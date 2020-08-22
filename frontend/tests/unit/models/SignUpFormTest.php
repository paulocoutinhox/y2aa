<?php

namespace frontend\tests\unit\models;

use Codeception\Test\Unit;
use common\models\domain\Customer;
use frontend\fixtures\CustomerFixture;
use frontend\models\form\SignUpForm;
use frontend\tests\UnitTester;

class SignUpFormTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;


    public function _before()
    {
        $this->tester->haveFixtures([
            'customer' => [
                'class' => CustomerFixture::class,
                'dataFile' => codecept_data_dir() . 'customer.php'
            ]
        ]);
    }

    public function testCorrectSignUp()
    {
        $model = new SignUpForm([
            'email' => 'some_email@example.com',
            'password' => 'some_password',
        ]);

        $customer = $model->signup();
        expect($customer)->true();

        /** @var Customer $customer */
        $customer = $this->tester->grabRecord('common\models\domain\Customer', [
            'email' => 'some_email@example.com',
            'status' => Customer::STATUS_INACTIVE
        ]);

        $this->tester->seeEmailIsSent();

        $mail = $this->tester->grabLastSentEmail();

        expect($mail)->isInstanceOf('yii\mail\MessageInterface');
        expect($mail->getTo())->hasKey('some_email@example.com');
        expect($mail->getFrom())->hasKey(\Yii::$app->params['supportEmail']);
        expect($mail->getSubject())->equals('Account registration at ' . \Yii::$app->name);
        expect($mail->toString())->stringContainsString($customer->verification_token);
    }

    public function testNotCorrectSignUp()
    {
        $model = new SignUpForm([
            'email' => 'nicolas.dianna@hotmail.com',
            'password' => 'some_password',
        ]);

        expect_not($model->signup());
        expect_that($model->getErrors('email'));

        expect($model->getFirstError('email'))
            ->equals('This email address has already been taken.');
    }
}
