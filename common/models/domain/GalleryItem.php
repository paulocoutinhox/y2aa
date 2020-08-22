<?php

namespace common\models\domain;

use common\models\query\GalleryItemQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%gallery_item}}".
 *
 * @property integer $id
 * @property integer $gallery_id
 * @property string $path
 * @property string $base_url
 * @property string $type
 * @property integer $size
 * @property string $name
 * @property integer $order
 * @property integer $created_at
 */
class GalleryItem extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gallery_item}}';
    }

    /**
     * @inheritdoc
     * @return GalleryItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GalleryItemQuery(get_called_class());
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
        $scenarios['create'] = ['gallery_id', 'path', 'size', 'base_url', 'type', 'name', 'order'];
        $scenarios['update'] = [];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gallery_id', 'path'], 'required'],
            [['gallery_id', 'size', 'order', 'created_at'], 'integer'],
            [['path', 'base_url', 'type', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gallery_id' => Yii::t('common', 'Model.GalleryId'),
            'path' => Yii::t('common', 'Model.Path'),
            'base_url' => Yii::t('common', 'Model.BaseUrl'),
            'type' => Yii::t('common', 'Model.Type'),
            'size' => Yii::t('common', 'Model.Size'),
            'name' => Yii::t('common', 'Model.Name'),
            'order' => Yii::t('common', 'Model.Order'),

            'id' => Yii::t('common', 'Model.Id'),
            'created_at' => Yii::t('common', 'Model.CreatedAt'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getGallery()
    {
        return $this->hasOne(Gallery::class, ['id' => 'gallery_id']);
    }

    /**
     * @param bool $scheme
     * @return string
     */
    public function getUrl($scheme = false)
    {
        return Url::to($this->base_url . '/' . $this->path, $scheme);
    }

}
