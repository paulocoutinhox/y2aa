<?php

namespace common\models\domain;

use Yii;
use yii\base\Model;

class Query extends Model
{

    const QUERY_TYPE_INSERT = 'insert';
    const QUERY_TYPE_SElECT = 'select';
    const QUERY_TYPE_DELETE = 'delete';
    const QUERY_TYPE_UPDATE = 'update';

    public $query;
    public $type;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['query', 'type'], 'required'],
            [['query'], 'string'],
            ['type', 'in', 'range' => [self::QUERY_TYPE_INSERT, self::QUERY_TYPE_DELETE, self::QUERY_TYPE_SElECT, self::QUERY_TYPE_UPDATE]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'query' => Yii::t('common', 'Model.Query'),
            'type' => Yii::t('common', 'Model.Type'),
        ];
    }

}
