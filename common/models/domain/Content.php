<?php

namespace common\models\domain;

use common\models\query\ContentQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%content}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $tag
 * @property string $content
 * @property integer $language_id
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Content extends ActiveRecord
{

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    const TAG_ABOUT_US = 'about-us';
    const TAG_TERMS_OF_USE = 'terms-of-use';
    const TAG_PRIVACY_POLICY = 'privacy-policy';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%content}}';
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
     * @return ContentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ContentQuery(get_called_class());
    }

    /**
     * @return array
     */
    public static function getTagList()
    {
        return [
            self::TAG_ABOUT_US => Yii::t('common', 'Content.Tag.AboutUs'),
            self::TAG_TERMS_OF_USE => Yii::t('common', 'Content.Tag.TermsOfUse'),
            self::TAG_PRIVACY_POLICY => Yii::t('common', 'Content.Tag.PrivacyPolicy'),
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
        $scenarios['create'] = ['title', 'tag', 'content', 'language_id', 'status'];
        $scenarios['update'] = ['title', 'tag', 'content', 'language_id', 'status'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'status'], 'string'],
            [['language_id', 'created_at', 'updated_at'], 'integer'],
            [['title', 'tag'], 'string', 'max' => 255],
            [['title', 'tag', 'status'], 'required'],
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
            'content' => Yii::t('common', 'Model.Content'),
            'language_id' => Yii::t('common', 'Model.LanguageId'),
            'status' => Yii::t('common', 'Model.Status'),

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

}
