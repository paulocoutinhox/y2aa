<?php

namespace common\models\domain;

use common\models\query\GalleryQuery;
use common\models\util\StringUtil;
use Throwable;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%gallery}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $tag
 * @property integer $language_id
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Gallery extends ActiveRecord
{

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    const TAG_FRONTEND = 'frontend';

    /**
     * @var
     */
    public $items;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gallery}}';
    }

    /**
     * @inheritdoc
     * @return GalleryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GalleryQuery(get_called_class());
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
    public static function getTagList()
    {
        return [
            self::TAG_FRONTEND => Yii::t('common', 'Gallery.Tag.Frontend'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => UploadBehavior::class,
                'attribute' => 'items',
                'filesStorage' => 'galleryFileStorage',
                'multiple' => true,
                'uploadRelation' => 'galleryItems',
                'pathAttribute' => 'path',
                'baseUrlAttribute' => 'base_url',
                'orderAttribute' => 'order',
                'typeAttribute' => 'type',
                'sizeAttribute' => 'size',
                'nameAttribute' => 'name',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['title', 'tag', 'language_id', 'status', 'items'];
        $scenarios['update'] = ['title', 'tag', 'language_id', 'status', 'items'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'tag'], 'required'],
            [['language_id', 'created_at', 'updated_at'], 'integer'],
            [['status'], 'string'],
            [['title', 'tag'], 'string', 'max' => 255],
            ['items', 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('common', 'Model.Title'),
            'tag' => Yii::t('common', 'Model.Tag'),
            'language_id' => Yii::t('common', 'Model.LanguageId'),
            'status' => Yii::t('common', 'Model.Status'),
            'items' => Yii::t('common', 'Model.Gallery.Items'),

            'id' => Yii::t('common', 'Model.Id'),
            'created_at' => Yii::t('common', 'Model.CreatedAt'),
            'updated_at' => Yii::t('common', 'Model.UpdatedAt'),
        ];
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
     * @return ActiveQuery
     */
    public function getGalleryItems()
    {
        return $this->hasMany(GalleryItem::class, ['gallery_id' => 'id']);
    }

    /**
     * @param bool $scheme
     * @return string
     */
    public function getUrl($scheme = false)
    {
        return Url::to(['/gallery/index', 'id' => $this->id, 'title' => StringUtil::slug($this->title)], $scheme);
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        {
            // delete gallery item
            $items = GalleryItem::find()->galleryId($this->id)->all();

            foreach ($items as $item) {
                try {
                    $item->delete();
                } catch (Throwable $e) {
                    // ignore
                }
            }
        }

        return parent::beforeDelete();
    }

}
