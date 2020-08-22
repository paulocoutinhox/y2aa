<?php

namespace common\models\query;

use common\models\domain\UserGroup;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\domain\UserGroup]].
 *
 * @see \common\models\domain\UserGroup
 */
class UserGroupQuery extends ActiveQuery
{

    /**
     * @inheritdoc
     * @return UserGroup[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return UserGroup|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
