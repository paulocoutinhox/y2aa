<?php

namespace frontend\tests\unit\models;

use Codeception\Test\Unit;
use common\models\domain\Customer;
use frontend\fixtures\CustomerFixture;
use frontend\models\form\RequestPasswordResetForm;
use frontend\tests\UnitTester;
use Yii;

class RequestPasswordResetFormTest extends Unit
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

    public function testSendMessageWithWrongEmailAddress()
    {
        $model = new RequestPasswordResetForm();
        $model->email = 'not-existing-email@example.com';
        expect_not($model->sendEmail());
    }

    public function testNotSendEmailsToInactiveCustomer()
    {
        $customer = $this->tester->grabFixture('customer', 1);
        $model = new RequestPasswordResetForm();
        $model->email = $customer['email'];
        expect_not($model->sendEmail());
    }

    public function testSendEmailSuccessfully()
    {
        $customerFixture = $this->tester->grabFixture('customer', 0);

        $model = new RequestPasswordResetForm();
        $model->email = $customerFixture['email'];
        $customer = Customer::findOne(['password_reset_token' => $customerFixture['password_reset_token']]);

        expect_that($model->sendEmail());
        expect_that($customer->password_reset_token);

        $emailMessage = $this->tester->grabLastSentEmail();
        expect('valid email is sent', $emailMessage)->isInstanceOf('yii\mail\MessageInterface');
        expect($emailMessage->getTo())->hasKey($model->email);
        expect($emailMessage->getFrom())->hasKey(Yii::$app->params['supportEmail']);
    }
}
