<?php

namespace common\models\query;

use common\models\domain\Language;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\domain\Language]].
 *
 * @see \common\models\domain\Language
 */
class LanguageQuery extends ActiveQuery
{

    public function onlyAllowedLanguage()
    {
        if (Yii::$app->user->getIdentity()->isRoot()) {
            return $this;
        } else if ((int)Yii::$app->user->getIdentity()->language_id == 0) {
            return $this;
        } else {
            return $this->andWhere('id = :id', ['id' => Yii::$app->user->getIdentity()->language_id]);
        }
    }

    public function iso6391($code)
    {
        return $this->andWhere('[[code_iso_639_1]] = :code', ['code' => $code]);
    }

    public function codeISO($code)
    {
        return $this->andWhere('[[code_iso_language]] = :code', ['code' => $code]);
    }

    /**
     * @inheritdoc
     * @return Language[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Language|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
