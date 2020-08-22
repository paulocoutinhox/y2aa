<?php

namespace common\models\query;

use common\models\domain\Permission;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\domain\Permission]].
 *
 * @see \common\models\domain\Permission
 */
class PermissionQuery extends ActiveQuery
{

    public function active()
    {
        return $this->andWhere('[[status]] = :status', ['status' => Permission::STATUS_ACTIVE]);
    }

    public function orderByActionGroupAndAction()
    {
        return $this->addOrderBy('[[action_group]] ASC')->addOrderBy('[[action]] ASC');
    }

    /**
     * @inheritdoc
     * @return Permission[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Permission|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
