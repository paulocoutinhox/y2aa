<?php

namespace common\models\query;

use common\models\domain\User;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\domain\User]].
 *
 * @see \common\models\domain\User
 */
class UserQuery extends ActiveQuery
{

    public function id($id)
    {
        return $this->andWhere('[[id]] = :id', ['id' => $id]);
    }

    public function email($email)
    {
        return $this->andWhere('[[email]] = :email', ['email' => $email]);
    }

    /**
     * @inheritdoc
     * @return User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
