<?php

namespace backend\components;

use Yii;
use yii\rbac\CheckAccessInterface;

class AccessChecker implements CheckAccessInterface
{

    public function checkAccess($userId, $permissionName, $params = [])
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        if (Yii::$app->user->getIdentity()->isRoot()) {
            return true;
        }

        return Yii::$app->user->getIdentity()->hasPermission($permissionName);
    }

}