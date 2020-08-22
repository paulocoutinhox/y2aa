<?php

namespace common\models\query;

use common\models\domain\GroupPermission;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\domain\GroupPermission]].
 *
 * @see \common\models\domain\GroupPermission
 */
class GroupPermissionQuery extends ActiveQuery
{

    /**
     * @inheritdoc
     * @return GroupPermission[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return GroupPermission|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
