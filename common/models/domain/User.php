<?php

namespace common\models\domain;

use common\components\validator\TimeZoneValidator;
use common\models\query\UserQuery;
use Lcobucci\JWT\Signer\Hmac\Sha512;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property integer $language_id
 * @property string $name
 * @property string $auth_key
 * @property string $password
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $status
 * @property string $root
 * @property string $gender
 * @property string $avatar_path
 * @property string $avatar_base_url
 * @property string $timezone
 * @property array $groups
 * @property integer $logged_at
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    const ROOT_YES = 'yes';
    const ROOT_NO = 'no';

    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';

    /**
     * @var
     */
    public $groups;

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
        return '{{%user}}';
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
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by email
     *
     * @param string email
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
        $expire = Yii::$app->params['userPasswordResetTokenExpire'];
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
     * @return array
     */
    public static function getRootList()
    {
        return [
            self::ROOT_YES => Yii::t('common', 'Root.Yes'),
            self::ROOT_NO => Yii::t('common', 'Root.No'),
        ];
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
            'password_reset_token' => [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'password_reset_token'
                ],
                'value' => function () {
                    return Yii::$app->getSecurity()->generateRandomString(40);
                }
            ],
            [
                'class' => UploadBehavior::class,
                'attribute' => 'avatar',
                'pathAttribute' => 'avatar_path',
                'baseUrlAttribute' => 'avatar_base_url',
                'filesStorage' => 'userProfileFileStorage',
            ]
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['name', 'email', 'password', 'gender', 'status', 'root', 'repeat_password', 'language_id', 'timezone', 'groups'];
        $scenarios['update'] = ['name', 'email', 'password', 'gender', 'status', 'root', 'repeat_password', 'language_id', 'timezone', 'groups'];
        $scenarios['update-profile'] = ['name', 'email', 'password', 'gender', 'repeat_password', 'avatar', 'language_id', 'timezone'];
        $scenarios['check'] = ['id', 'name', 'email', 'gender', 'avatar', 'language_id', 'timezone', 'created_at'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            [['name', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['password', 'repeat_Password'], 'string', 'on' => ['create']],
            [['repeat_password'], 'compare', 'compareAttribute' => 'password', 'on' => ['create']],
            [['password', 'repeat_password'], 'required', 'on' => ['create']],
            [['password_reset_token'], 'unique'],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'string', 'min' => 3, 'max' => 255],
            ['email', 'email'],
            ['email', 'unique',
                'targetClass' => '\common\models\domain\User',
                'message' => Yii::t('common', 'Error.User.EmailTaken'),
                'filter' => function ($query) {
                    $query->andWhere(['not', ['id' => $this->id]]);
                }
            ],
            ['gender', 'default', 'value' => null],
            ['gender', 'in', 'range' => [self::GENDER_MALE, self::GENDER_FEMALE]],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
            ['root', 'default', 'value' => self::ROOT_NO],
            ['root', 'in', 'range' => [self::ROOT_YES, self::ROOT_NO]],
            ['language_id', 'integer'],
            [['created_at', 'updated_at'], 'integer'],
            ['groups', 'each', 'rule' => ['integer']],
            [['avatar_path', 'avatar_base_url'], 'string', 'max' => 255],
            ['avatar', 'safe'],
            ['timezone', 'required'],
            ['timezone', TimeZoneValidator::class],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('common', 'Model.Name'),
            'auth_key' => Yii::t('common', 'Model.AuthKey'),
            'password_hash' => Yii::t('common', 'Model.PasswordHash'),
            'password_reset_token' => Yii::t('common', 'Model.PasswordResetToken'),
            'email' => Yii::t('common', 'Model.Email'),
            'gender' => Yii::t('common', 'Model.Gender'),
            'status' => Yii::t('common', 'Model.Status'),
            'language_id' => Yii::t('common', 'Model.LanguageId'),
            'root' => Yii::t('common', 'Model.Root'),
            'logged_at' => Yii::t('common', 'Model.LoggedAt'),
            'avatar' => Yii::t('common', 'Model.Avatar'),
            'avatar_path' => Yii::t('common', 'Model.Avatar'),
            'avatar_url' => Yii::t('common', 'Model.Avatar'),
            'password' => Yii::t('common', 'Model.Password'),
            'repeat_password' => Yii::t('common', 'Model.RepeatPassword'),
            'timezone' => Yii::t('common', 'Model.TimeZone'),

            'id' => Yii::t('common', 'Model.Id'),
            'created_at' => Yii::t('common', 'Model.CreatedAt'),
            'updated_at' => Yii::t('common', 'Model.UpdatedAt'),
        ];
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
        if ($this->name) {
            return $this->name;
        }

        return $this->email;
    }

    /**
     * Return the current user is root or no
     * @return boolean
     */
    public function isRoot()
    {
        return ($this->root == self::ROOT_YES);
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
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        // delete and save all new permissions
        $allowedScenario = ['create', 'update'];

        if (in_array($this->getScenario(), $allowedScenario)) {
            UserGroup::deleteAll(['user_id' => $this->id]);

            if ($this->groups) {
                foreach ($this->groups as $group) {
                    $groupPermission = new UserGroup();
                    $groupPermission->user_id = $this->id;
                    $groupPermission->group_id = $group;
                    $groupPermission->save();
                }
            }
        }

        return parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        UserGroup::deleteAll(['user_id' => $this->id]);

        return parent::beforeDelete();
    }

    /**
     * Return related permissions
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getGroups()
    {
        return $this->hasMany(Group::class, ['id' => 'group_id'])->viaTable(UserGroup::tableName(), ['user_id' => 'id']);
    }

    /**
     * Check if user has access to permission
     * @param $permission
     * @return bool
     * @throws \yii\db\Exception
     */
    public function hasPermission($permission)
    {
        $query = '
        SELECT COUNT(*)
        FROM user u
        INNER JOIN `user_group` ug ON ug.user_id = u.id
        INNER JOIN `group` g ON g.id = ug.group_id
        INNER JOIN `group_permission` gp ON gp.group_id = ug.group_id
        INNER JOIN `permission` p ON p.id = gp.permission_id
        WHERE
        u.id = :user_id
        AND p.action = :action
        AND g.status = :group_status
        AND p.status = :permission_status
        ';

        $count = (int)Yii::$app->db->createCommand($query, [
            'user_id' => Yii::$app->user->id,
            'action' => $permission,
            'group_status' => Group::STATUS_ACTIVE,
            'permission_status' => Permission::STATUS_ACTIVE,
        ])->queryScalar();

        return ($count > 0);
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

    public function doAfterLogin()
    {
        // ignore
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
                ->set('gender', $this->gender)
                ->set('language_id', $this->language_id)
                ->set('created_at', $this->created_at)
                ->sign($signer, Yii::$app->jwt->key)
                ->getToken();
        }

        return null;
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

}
