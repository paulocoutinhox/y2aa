<?php

namespace common\models\domain;

use common\components\validator\TimeZoneValidator;
use common\models\query\CustomerQuery;
use Lcobucci\JWT\Signer\Hmac\Sha512;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\base\Exception;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\IdentityInterface;
use yiibr\brvalidator\CpfValidator;

/**
 * This is the model class for table "{{%customer}}".
 *
 * @property integer $id
 * @property integer $language_id
 * @property string $name
 * @property string $cpf
 * @property string $mobile_phone
 * @property string $home_phone
 * @property string $email
 * @property string $auth_key
 * @property string $password
 * @property string $repeat_password
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $status
 * @property string $gender
 * @property string $avatar
 * @property string $avatar_path
 * @property string $avatar_base_url
 * @property string $obs
 * @property string $timezone
 * @property integer $logged_at
 * @property integer $created_at
 * @property integer $updated_at
 */
class Customer extends ActiveRecord implements IdentityInterface
{

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_DELETED = 'deleted';

    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';

    /**
     * @var
     */
    public $password;

    /**
     * @var
     */
    public $repeat_password;

    /**
     * @var
     */
    public $avatar;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%customer}}';
    }

    /**
     * @inheritdoc
     * @throws Exception
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            'auth_key' => [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'auth_key'
                ],
                'value' => Yii::$app->getSecurity()->generateRandomString()
            ],
            [
                'class' => UploadBehavior::class,
                'attribute' => 'avatar',
                'pathAttribute' => 'avatar_path',
                'baseUrlAttribute' => 'avatar_base_url',
                'filesStorage' => 'customerProfileFileStorage',
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['name', 'cpf', 'email', 'mobile_phone', 'home_phone', 'password', 'gender', 'status', 'repeat_password', 'language_id', 'timezone', 'obs'];
        $scenarios['update'] = ['name', 'cpf', 'email', 'mobile_phone', 'home_phone', 'gender', 'status', 'language_id', 'timezone', 'obs'];
        $scenarios['update-profile'] = ['name', 'cpf', 'email', 'mobile_phone', 'password', 'gender', 'repeat_password', 'avatar', 'language_id', 'timezone', 'obs'];
        $scenarios['update-password'] = ['password', 'repeat_password'];
        $scenarios['update-image'] = ['avatar'];
        $scenarios['check'] = ['id', 'name', 'cpf', 'email', 'mobile_phone', 'home_phone', 'gender', 'avatar', 'language_id', 'timezone', 'obs', 'created_at'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['language_id', 'cpf', 'name', 'mobile_phone', 'email', 'timezone', 'status'], 'required'],
            [['language_id', 'logged_at', 'created_at', 'updated_at'], 'integer'],
            [['status', 'gender'], 'string'],
            [['cpf'], 'string', 'min' => 11, 'max' => 11],
            ['cpf', CpfValidator::class],
            [['mobile_phone', 'home_phone'], 'string', 'min' => 10, 'max' => 11],
            ['name', 'string', 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'string', 'max' => 255],
            ['email', 'email'],
            ['email', 'unique',
                'targetClass' => '\common\models\domain\Customer',
                'message' => Yii::t('common', 'Error.Customer.EmailTaken'),
                'filter' => function ($query) {
                    $query->andWhere(['not', ['id' => $this->id]]);
                }
            ],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'verification_token', 'avatar_path', 'avatar_base_url', 'timezone'], 'string', 'max' => 255],
            [['password_reset_token', 'verification_token'], 'unique'],
            [['password', 'repeat_password'], 'string', 'on' => ['create', 'update-password']],
            [['repeat_password'], 'compare', 'compareAttribute' => 'password', 'on' => ['create', 'update-password']],
            [['password', 'repeat_password'], 'required', 'on' => ['create', 'update-password']],
            ['gender', 'default', 'value' => null],
            ['gender', 'in', 'range' => [self::GENDER_MALE, self::GENDER_FEMALE]],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            ['timezone', TimeZoneValidator::class],
            ['obs', 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('common', 'Model.Name'),
            'cpf' => Yii::t('common', 'Model.CPF'),
            'mobile_phone' => Yii::t('common', 'Model.MobilePhone'),
            'home_phone' => Yii::t('common', 'Model.HomePhone'),
            'email' => Yii::t('common', 'Model.Email'),
            'auth_key' => Yii::t('common', 'Model.AuthKey'),
            'password_hash' => Yii::t('common', 'Model.PasswordHash'),
            'password_reset_token' => Yii::t('common', 'Model.PasswordResetToken'),
            'verification_token' => Yii::t('common', 'Model.VerificationToken'),
            'gender' => Yii::t('common', 'Model.Gender'),
            'status' => Yii::t('common', 'Model.Status'),
            'language_id' => Yii::t('common', 'Model.LanguageId'),
            'logged_at' => Yii::t('common', 'Model.LoggedAt'),
            'avatar' => Yii::t('common', 'Model.Avatar'),
            'avatar_path' => Yii::t('common', 'Model.Avatar'),
            'avatar_url' => Yii::t('common', 'Model.Avatar'),
            'password' => Yii::t('common', 'Model.Password'),
            'repeat_password' => Yii::t('common', 'Model.RepeatPassword'),
            'timezone' => Yii::t('common', 'Model.TimeZone'),
            'obs' => Yii::t('common', 'Model.Obs'),

            'id' => Yii::t('common', 'Model.Id'),
            'created_at' => Yii::t('common', 'Model.CreatedAt'),
            'updated_at' => Yii::t('common', 'Model.UpdatedAt'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $id = (int)$token->getClaim('id', 0);
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification token
     *
     * @param string $token verification token
     * @return static|null
     */
    public static function findByVerificationToken($token)
    {
        if (!static::isVerificationTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['customerPasswordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * Finds out if verification token is valid
     *
     * @param string $token verification token
     * @return bool
     */
    public static function isVerificationTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['customerVerificationTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @return array
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => Yii::t('common', 'Status.Active'),
            self::STATUS_INACTIVE => Yii::t('common', 'Status.Inactive'),
            self::STATUS_DELETED => Yii::t('common', 'Status.Deleted'),
        ];
    }

    /**
     * @return array
     */
    public static function getGenderList()
    {
        return [
            self::GENDER_MALE => Yii::t('common', 'Gender.Male'),
            self::GENDER_FEMALE => Yii::t('common', 'Gender.Female'),
        ];
    }

    /**
     * @inheritdoc
     * @return CustomerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CustomerQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     * @throws Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     * @throws Exception
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @return string
     */
    public function getPublicIdentity()
    {
        if (empty($this->name)) {
            return $this->email;
        } else {
            return $this->name;
        }
    }

    /**
     * Return related language
     * @return ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::class, ['id' => 'language_id']);
    }

    /**
     * @param null $default
     * @param bool $scheme
     * @return bool|null|string
     */
    public function getAvatar($default = null, $scheme = false)
    {
        return $this->avatar_path
            ? Url::to(($this->avatar_base_url . '/' . $this->avatar_path), $scheme)
            : $default;
    }

    /**
     * Get a token for login with customer data
     * @return mixed
     */
    public function getTokenForLogin()
    {
        $signer = new Sha512();

        if (isset(Yii::$app->jwt)) {
            return Yii::$app->jwt->getBuilder()
                ->setIssuedAt(time())
                ->set('id', $this->id)
                ->set('name', $this->name)
                ->set('email', $this->email)
                ->set('mobile_phone', $this->mobile_phone)
                ->set('gender', $this->gender)
                ->set('language_id', $this->language_id)
                ->set('created_at', $this->created_at)
                ->sign($signer, Yii::$app->jwt->key)
                ->getToken();
        }

        return null;
    }

    public function doAfterLogin()
    {
        // ignore
    }

    public function doAfterSignUp()
    {
        // ignore
    }

    public function doAfterSignUpVerification()
    {
        // ignore
    }

}
