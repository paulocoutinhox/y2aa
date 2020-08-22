<?php

namespace common\models\util;

use Yii;

class WebUtil
{

    public static function isActionActive($actionList)
    {
        if (empty($actionList)) {
            return false;
        }

        foreach ($actionList as $action) {
            $action = trim($action);
            $action = trim($action, '/');
            $actionData = explode('/', $action);

            if (count($actionData) == 3) {
                $actionId = $actionData[2];
                $controllerId = $actionData[0] . '/' . $actionData[1];

                $actionData[0] = $controllerId;
                $actionData[1] = $actionId;

                unset($actionData[2]);
            }

            if (count($actionData) == 2) {
                $controllerId = $actionData[0];
                $actionId = $actionData[1];

                if (Yii::$app->controller->id == $controllerId && Yii::$app->controller->action->id == $actionId) {
                    return true;
                } else if (Yii::$app->controller->id == $controllerId && $actionId == '*') {
                    return true;
                }
            }
        }

        return false;
    }

}