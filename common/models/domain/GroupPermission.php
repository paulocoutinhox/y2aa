<?php

namespace common\models\domain;

use common\models\query\GroupPermissionQuery;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%group_permission}}".
 *
 * @property integer $group_id
 * @property integer $permission_id
 */
class GroupPermission extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%group_permission}}';
    }

    /**
     * @inheritdoc
     * @return GroupPermissionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GroupPermissionQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'permission_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'group_id' => Yii::t('common', 'Model.UserId'),
            'permission_id' => Yii::t('common', 'Model.PermissionId'),
        ];
    }

}
