<?php

namespace common\models\domain;

use common\models\query\UserGroupQuery;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%user_group}}".
 *
 * @property integer $user_id
 * @property integer $group_id
 */
class UserGroup extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_group}}';
    }

    /**
     * @inheritdoc
     * @return UserGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserGroupQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['user_id', 'group_id'];
        $scenarios['update'] = ['user_id', 'group_id'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'group_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('common', 'Model.UserId'),
            'group_id' => Yii::t('common', 'Model.GroupId'),
        ];
    }

}
