<?php

namespace frontend\models\form;

use common\components\validator\TimeZoneValidator;
use common\models\domain\Customer;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yiibr\brvalidator\CpfValidator;

/**
 * SignUp form
 */
class SignUpForm extends Model
{

    public $name;
    public $cpf;
    public $mobilePhone;
    public $email;
    public $password;
    public $repeatPassword;
    public $languageId;
    public $gender;
    public $timezone;
    public $obs;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['languageId', 'cpf', 'name', 'mobilePhone', 'email', 'timezone', 'password', 'repeatPassword'], 'required'],
            [['languageId'], 'integer'],
            ['gender', 'string'],
            ['gender', 'in', 'range' => [Customer::GENDER_MALE, Customer::GENDER_FEMALE]],
            [['cpf'], 'string', 'min' => 11, 'max' => 11],
            ['cpf', CpfValidator::class],
            [['mobilePhone'], 'string', 'min' => 10, 'max' => 11],
            [['name', 'obs'], 'string', 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'string', 'max' => 255],
            ['email', 'email'],
            ['email', 'unique',
                'targetClass' => '\common\models\domain\Customer',
                'message' => Yii::t('common', 'Error.Customer.EmailTaken'),
            ],
            ['timezone', 'string', 'max' => 255],
            ['repeatPassword', 'compare', 'compareAttribute' => 'password'],
            ['password', 'string', 'min' => Yii::$app->params['customerPasswordMinLength']],
            ['timezone', TimeZoneValidator::class],
            ['verifyCode', 'captcha', 'when' => function () {
                return (Yii::$app->params['captchaOnSignUp'] === true);
            }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cpf' => Yii::t('common', 'Model.CPF'),
            'name' => Yii::t('common', 'Model.Name'),
            'mobilePhone' => Yii::t('common', 'Model.MobilePhone'),
            'email' => Yii::t('common', 'Model.Email'),
            'gender' => Yii::t('common', 'Model.Gender'),
            'languageId' => Yii::t('common', 'Model.LanguageId'),
            'password' => Yii::t('common', 'Model.Password'),
            'repeatPassword' => Yii::t('common', 'Model.RepeatPassword'),
            'timezone' => Yii::t('common', 'Model.TimeZone'),
            'obs' => Yii::t('common', 'Model.Obs'),
            'verifyCode' => Yii::t('common', 'Model.VerifyCode'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return Customer|null the saved model or null if saving fails
     * @throws Exception
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $customer = new Customer();
        $customer->name = $this->name;
        $customer->cpf = $this->cpf;
        $customer->email = $this->email;
        $customer->language_id = $this->languageId;
        $customer->gender = $this->gender;
        $customer->timezone = $this->timezone;
        $customer->mobile_phone = $this->mobilePhone;
        $customer->obs = $this->obs;

        $customer->setPassword($this->password);
        $customer->generateAuthKey();

        if (Yii::$app->params['customerHasSignUpVerification']) {
            $customer->status = Customer::STATUS_INACTIVE;
            $customer->generateEmailVerificationToken();

            $result = (($customer->save() && $this->sendEmail($customer)) ? $customer : null);

            if ($result) {
                $customer->doAfterSignUp();
            }

            return $result;
        } else {
            $customer->status = Customer::STATUS_ACTIVE;
            $result = ($customer->save() ? $customer : null);

            if ($result) {
                $this->sendWelcomeEmail($customer);
                $customer->doAfterSignUp();
            }

            return $result;
        }
    }

    /**
     * Sends confirmation email to customer
     * @param Customer $customer customer model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($customer)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'signupVerification-html', 'text' => 'signupVerification-text'],
                ['customer' => $customer]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setTo($customer->email)
            ->setSubject(Yii::t('common', 'Mail.SignUpVerification.Subject', ['name' => Yii::$app->name]))
            ->send();
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
