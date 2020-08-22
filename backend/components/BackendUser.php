<?php

namespace backend\components;

use yii\web\User;

class BackendUser extends User
{

    protected function getAccessChecker()
    {
        if ($this->accessChecker == null) {
            $this->accessChecker = new AccessChecker();
        }

        return $this->accessChecker;
    }

}