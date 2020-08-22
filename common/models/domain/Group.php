<?php

namespace common\models\domain;

use common\models\query\GroupQuery;
use Yii;
use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%group}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property array $permissions
 */
class Group extends ActiveRecord
{

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    public $permissions;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%group}}';
    }

    /**
     * @inheritdoc
     * @return GroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GroupQuery(get_called_class());
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
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['name', 'status', 'permissions'];
        $scenarios['update'] = ['name', 'status', 'permissions'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'status'], 'required'],
            [['status'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('common', 'Model.Name'),
            'status' => Yii::t('common', 'Model.Status'),

            'id' => Yii::t('common', 'Model.Id'),
            'created_at' => Yii::t('common', 'Model.CreatedAt'),
            'updated_at' => Yii::t('common', 'Model.UpdatedAt'),
        ];
    }

    /**
     * Return related permissions
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getPermissions()
    {
        return $this->hasMany(Permission::class, ['id' => 'permission_id'])->viaTable(GroupPermission::tableName(), ['group_id' => 'id']);
    }

    /**
     * Return related users
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->viaTable(UserGroup::tableName(), ['group_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        // delete and save all new permissions
        GroupPermission::deleteAll(['group_id' => $this->id]);

        if ($this->permissions) {
            foreach ($this->permissions as $permission) {
                $groupPermission = new GroupPermission();
                $groupPermission->group_id = $this->id;
                $groupPermission->permission_id = $permission;
                $groupPermission->save();
            }
        }

        return parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        GroupPermission::deleteAll(['group_id' => $this->id]);
        UserGroup::deleteAll(['group_id' => $this->id]);

        return parent::beforeDelete();
    }

}
