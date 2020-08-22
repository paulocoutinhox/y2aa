<?php

namespace frontend\tests\unit\models;

use Codeception\Test\Unit;
use frontend\fixtures\CustomerFixture;
use frontend\models\form\ResendVerificationEmailForm;
use frontend\tests\UnitTester;

class ResendVerificationEmailFormTest extends Unit
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

    public function testWrongEmailAddress()
    {
        $model = new ResendVerificationEmailForm();
        $model->attributes = [
            'email' => 'wrong@prsolucoes.com'
        ];

        expect($model->validate())->false();
        expect($model->hasErrors())->true();
        expect($model->getFirstError('email'))->equals('There is no customer with this email address.');
    }

    public function testEmptyEmailAddress()
    {
        $model = new ResendVerificationEmailForm();
        $model->attributes = [
            'email' => ''
        ];

        expect($model->validate())->false();
        expect($model->hasErrors())->true();
        expect($model->getFirstError('email'))->equals('Email cannot be blank.');
    }

    public function testResendToActiveCustomer()
    {
        $model = new ResendVerificationEmailForm();
        $model->attributes = [
            'email' => 'test2@mail.com'
        ];

        expect($model->validate())->false();
        expect($model->hasErrors())->true();
        expect($model->getFirstError('email'))->equals('There is no customer with this email address.');
    }

    public function testSuccessfullyResend()
    {
        $model = new ResendVerificationEmailForm();
        $model->attributes = [
            'email' => 'test@mail.com'
        ];

        expect($model->validate())->true();
        expect($model->hasErrors())->false();

        expect($model->sendEmail())->true();
        $this->tester->seeEmailIsSent();

        $mail = $this->tester->grabLastSentEmail();

        expect('valid email is sent', $mail)->isInstanceOf('yii\mail\MessageInterface');
        expect($mail->getTo())->hasKey('test@mail.com');
        expect($mail->getFrom())->hasKey(\Yii::$app->params['supportEmail']);
        expect($mail->getSubject())->equals('Account registration at ' . \Yii::$app->name);
        expect($mail->toString())->stringContainsString('4ch0qbfhvWwkcuWqjN8SWRq72SOw1KYT_1548675330');
    }
}
