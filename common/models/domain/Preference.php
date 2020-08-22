<?php

namespace common\models\domain;

use common\models\query\PreferenceQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%preference}}".
 *
 * @property integer $id
 * @property string $key
 * @property string $value
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 */
class Preference extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%preference}}';
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
        $scenarios['create'] = ['key', 'description', 'value'];
        $scenarios['update'] = ['key', 'description', 'value'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'description'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['key', 'value', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'key' => Yii::t('common', 'Model.Key'),
            'value' => Yii::t('common', 'Model.Value'),
            'description' => Yii::t('common', 'Model.Description'),

            'id' => Yii::t('common', 'Model.Id'),
            'created_at' => Yii::t('common', 'Model.CreatedAt'),
            'updated_at' => Yii::t('common', 'Model.UpdatedAt'),
        ];
    }

    /**
     * @inheritdoc
     * @return PreferenceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PreferenceQuery(get_called_class());
    }

}
