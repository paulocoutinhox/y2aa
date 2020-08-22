<?php

namespace common\models\domain;

use common\models\query\PermissionQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%permission}}".
 *
 * @property integer $id
 * @property string $description
 * @property string $action
 * @property string $action_group
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Permission extends ActiveRecord
{

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%permission}}';
    }

    /**
     * @inheritdoc
     * @return PermissionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PermissionQuery(get_called_class());
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
        $scenarios['create'] = ['description', 'action', 'action_group', 'status'];
        $scenarios['update'] = ['description', 'action', 'action_group', 'status'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['action', 'description', 'status'], 'required'],
            [['status'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['description', 'action', 'action_group'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'description' => Yii::t('common', 'Model.Description'),
            'action' => Yii::t('common', 'Model.Action'),
            'action_group' => Yii::t('common', 'Model.ActionGroup'),
            'status' => Yii::t('common', 'Model.Status'),

            'id' => Yii::t('common', 'Model.Id'),
            'created_at' => Yii::t('common', 'Model.CreatedAt'),
            'updated_at' => Yii::t('common', 'Model.UpdatedAt'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        GroupPermission::deleteAll(['permission_id' => $this->id]);

        return parent::beforeDelete();
    }

}
