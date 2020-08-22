<?php

namespace common\models\query;

use common\models\domain\Gallery;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\domain\Gallery]].
 *
 * @see \common\models\domain\Gallery
 */
class GalleryQuery extends ActiveQuery
{

    public function onlyAllowedLanguage()
    {
        if (Yii::$app->user->getIdentity()->isRoot()) {
            return $this;
        } else if ((int)Yii::$app->user->getIdentity()->language_id == 0) {
            return $this;
        } else {
            return $this->andWhere('[[language_id]] = :language_id', ['language_id' => Yii::$app->user->getIdentity()->language_id]);
        }
    }

    public function active()
    {
        return $this->andWhere('[[status]] = :status', ['status' => Gallery::STATUS_ACTIVE]);
    }

    public function tag($tag)
    {
        return $this->andWhere('[[tag]] = :tag', ['tag' => $tag]);
    }

    public function languageId($languageId)
    {
        return $this->andWhere('[[language_id]] = :language_id', ['language_id' => $languageId]);
    }

    /**
     * @inheritdoc
     * @return \common\models\domain\Gallery[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\domain\Gallery|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
