<?php

namespace common\models\query;

use common\models\domain\Log;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\domain\Log]].
 *
 * @see \common\models\domain\Log
 */
class LogQuery extends ActiveQuery
{

    /**
     * @inheritdoc
     * @return Log[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Log|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
