<?php

namespace common\models\query;

use common\models\domain\Content;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\domain\Content]].
 *
 * @see \common\models\domain\Content
 */
class ContentQuery extends ActiveQuery
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

    public function tag($tag)
    {
        return $this->andWhere('[[tag]] = :tag', ['tag' => $tag]);
    }

    public function languageId($languageId)
    {
        return $this->andWhere('[[language_id]] = :language_id', ['language_id' => $languageId]);
    }

    public function id($id)
    {
        return $this->andWhere('[[id]] = :id', ['id' => $id]);
    }

    /**
     * @inheritdoc
     * @return Content[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Content|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
