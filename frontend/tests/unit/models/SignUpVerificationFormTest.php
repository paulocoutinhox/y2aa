<?php

namespace frontend\tests\unit\models;

use Codeception\Test\Unit;
use common\models\domain\Customer;
use frontend\fixtures\CustomerFixture;
use frontend\models\form\SignUpVerificationForm;
use frontend\tests\UnitTester;

class SignUpVerificationFormTest extends Unit
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

    public function testVerifyWrongToken()
    {
        $this->tester->expectThrowable('\yii\base\InvalidArgumentException', function () {
            new SignUpVerificationForm('');
        });

        $this->tester->expectThrowable('\yii\base\InvalidArgumentException', function () {
            new SignUpVerificationForm('notexistingtoken_1391882543');
        });
    }

    public function testAlreadyActivatedToken()
    {
        $this->tester->expectThrowable('\yii\base\InvalidArgumentException', function () {
            new SignUpVerificationForm('already_used_token_1548675330');
        });
    }

    public function testVerifyCorrectToken()
    {
        $model = new SignUpVerificationForm('JcMsyT69czYq8uAp6D6HrUdYwGAzhmY2_1598085992');
        $customer = $model->verifyEmail();
        expect($customer)->isInstanceOf('common\models\domain\Customer');

        expect($customer->email)->equals('test@mail.com');
        expect($customer->status)->equals(Customer::STATUS_ACTIVE);
        expect($customer->validatePassword('Test1234'))->true();
    }
}
