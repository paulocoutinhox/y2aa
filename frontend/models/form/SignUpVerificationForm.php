<?php

namespace frontend\models\form;

use common\models\domain\Customer;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Model;

class SignUpVerificationForm extends Model
{

    /**
     * @var string
     */
    public $token;

    /**
     * @var Customer
     */
    private $_customer;


    /**
     * Creates a form model with given token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws InvalidArgumentException if token is empty or not valid
     */
    public function __construct($token, array $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException(Yii::t('common', 'Error.Customer.ResendVerificationEmail.EmptyToken'));
        }

        $this->_customer = Customer::findByVerificationToken($token);

        if (!$this->_customer) {
            throw new InvalidArgumentException(Yii::t('common', 'Error.Customer.ResendVerificationEmail.InvalidToken'));
        }

        parent::__construct($config);
    }

    /**
     * Verify email
     *
     * @return Customer|null the saved model or null if saving fails
     */
    public function verifyEmail()
    {
        $customer = $this->_customer;
        $customer->status = Customer::STATUS_ACTIVE;
        $result = ($customer->save(false) ? $customer : null);

        if ($result) {
            $this->sendWelcomeEmail($customer);
            $customer->doAfterSignUpVerification();
        }

        return $result;
    }

    /**
     * Sends welcome email to customer
     * @param Customer $customer customer model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendWelcomeEmail($customer)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'welcome-html', 'text' => 'welcome-text'],
                ['customer' => $customer]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setTo($customer->email)
            ->setSubject(Yii::t('common', 'Mail.Welcome.Subject', ['name' => Yii::$app->name]))
            ->send();
    }

}
