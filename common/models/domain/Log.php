<?php

namespace common\models\domain;

use common\models\query\LogQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%log}}".
 *
 * @property integer $id
 * @property integer $customer_id
 * @property string $source
 * @property integer $level
 * @property string $description
 * @property integer $created_at
 */
class Log extends ActiveRecord
{

    const SOURCE_API = 'api';
    const SOURCE_EXTERNAL_SERVICE = 'external-service';
    const SOURCE_SYSTEM = 'sistema';

    const LEVEL_VERBOSE = 1;
    const LEVEL_DEBUG = 2;
    const LEVEL_INFO = 3;
    const LEVEL_WARNING = 4;
    const LEVEL_ERROR = 5;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%log}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['customer_id', 'level', 'description', 'source'];
        $scenarios['update'] = [];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'level', 'created_at'], 'integer'],
            [['level', 'source'], 'required'],
            [['description'], 'string'],
            [['source'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'customer_id' => Yii::t('common', 'Model.CustomerId'),
            'source' => Yii::t('common', 'Model.Source'),
            'level' => Yii::t('common', 'Model.Level'),
            'description' => Yii::t('common', 'Model.Description'),

            'id' => Yii::t('common', 'Model.Id'),
            'created_at' => Yii::t('common', 'Model.CreatedAt'),
        ];
    }

    /**
     * @inheritdoc
     * @return LogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LogQuery(get_called_class());
    }

    public static function create($level, $source, $description, $customerId = 0)
    {
        if (is_array($description)) {
            $description = print_r($description, true);
        }

        $log = new Log();
        $log->level = $level;
        $log->source = $source;
        $log->description = $description;
        $log->customer_id = $customerId;
        $log->save();

        return $log;
    }

    /**
     * @return array
     */
    public static function getLevelList()
    {
        return [
            self::LEVEL_VERBOSE => Yii::t('common', 'Level.Verbose'),
            self::LEVEL_DEBUG => Yii::t('common', 'Level.Debug'),
            self::LEVEL_INFO => Yii::t('common', 'Level.Info'),
            self::LEVEL_WARNING => Yii::t('common', 'Level.Warning'),
            self::LEVEL_ERROR => Yii::t('common', 'Level.Error'),
        ];
    }

    /**
     * @return array
     */
    public static function getSourceList()
    {
        return [
            self::SOURCE_API => Yii::t('common', 'Log.Source.Api'),
            self::SOURCE_EXTERNAL_SERVICE => Yii::t('common', 'Log.Source.ExternalService'),
            self::SOURCE_SYSTEM => Yii::t('common', 'Log.Source.System'),
        ];
    }

    /**
     * Return related customer
     * @return ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }

}
