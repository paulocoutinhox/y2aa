<?php

namespace common\models\domain;

use common\models\query\LanguageQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%language}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $native_name
 * @property string $code_iso_639_1
 * @property string $code_iso_language
 * @property integer $created_at
 * @property integer $updated_at
 */
class Language extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%language}}';
    }

    /**
     * @inheritdoc
     * @return LanguageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LanguageQuery(get_called_class());
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
        $scenarios['create'] = ['name', 'native_name', 'code_iso_639_1', 'code_iso_language'];
        $scenarios['update'] = ['name', 'native_name', 'code_iso_639_1', 'code_iso_language'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'native_name', 'code_iso_639_1', 'code_iso_language'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['name', 'native_name', 'code_iso_639_1', 'code_iso_language'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('common', 'Model.Name'),
            'native_name' => Yii::t('common', 'Model.NativeName'),
            'code_iso_639_1' => Yii::t('common', 'Model.Code-ISO-639-1'),
            'code_iso_language' => Yii::t('common', 'Model.Code-ISO-Language'),

            'id' => Yii::t('common', 'Model.Id'),
            'created_at' => Yii::t('common', 'Model.CreatedAt'),
            'updated_at' => Yii::t('common', 'Model.UpdatedAt'),
        ];
    }

}
