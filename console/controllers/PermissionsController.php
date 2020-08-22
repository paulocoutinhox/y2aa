<?php

namespace console\controllers;

use common\models\util\Logger;
use common\models\util\PermissionUtil;
use yii\console\Controller;

class PermissionsController extends Controller
{

    public function actionGenerate()
    {
        Logger::d('Generating...');
        PermissionUtil::updatePermissions();
        Logger::s('Permissions generated');
    }

}