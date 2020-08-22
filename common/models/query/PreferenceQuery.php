<?php

namespace common\models\query;

use common\models\domain\Preference;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\domain\Preference]].
 *
 * @see \common\models\domain\Preference
 */
class PreferenceQuery extends ActiveQuery
{

    public function key($key)
    {
        return $this->andWhere('[[key]] = :key', ['key' => $key]);
    }

    /**
     * @inheritdoc
     * @return Preference[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Preference|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
