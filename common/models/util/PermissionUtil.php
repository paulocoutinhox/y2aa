<?php

namespace common\models\util;

use common\models\domain\GroupPermission;
use common\models\domain\Permission;
use Exception;
use Throwable;
use Yii;

class PermissionUtil
{

    public static function updatePermissions()
    {
        $permissions = Yii::$app->params['permissions'];

        if ($permissions) {
            // remove permissions that no longer exist
            $currentPermissions = Permission::find()->all();

            if ($currentPermissions) {
                foreach ($currentPermissions as $currentPermission) {
                    $exists = false;

                    foreach ($permissions as $permission) {
                        if ($permission['action'] == $currentPermission->action) {
                            $exists = true;
                            break;
                        }
                    }

                    if (!$exists) {
                        try {
                            $currentPermission->delete();
                        } catch (Exception $e) {
                            // ignore
                        } catch (Throwable $e) {
                            // ignore
                        }
                    }
                }
            }

            // update remaining permissions
            $currentPermissions = Permission::find()->all();

            if ($currentPermissions) {
                foreach ($currentPermissions as $currentPermission) {
                    foreach ($permissions as $permission) {
                        if ($permission['action'] == $currentPermission->action) {
                            $currentPermission->description = $permission['description'];
                            $currentPermission->action_group = $permission['action_group'];

                            if (isset($permission['status'])) {
                                $currentPermission->status = $permission['status'];
                            } else {
                                $currentPermission->status = Permission::STATUS_ACTIVE;
                            }

                            $currentPermission->save();

                            break;
                        }
                    }
                }
            }

            // add new permissions
            foreach ($permissions as $permission) {
                $exists = false;

                foreach ($currentPermissions as $currentPermission) {
                    if ($permission['action'] == $currentPermission->action) {
                        $exists = true;
                        break;
                    }
                }

                if (!$exists) {
                    $newPermision = new Permission();
                    $newPermision->action = $permission['action'];
                    $newPermision->action_group = $permission['action_group'];
                    $newPermision->description = $permission['description'];

                    if (isset($permission['status'])) {
                        $newPermision->status = $permission['status'];
                    } else {
                        $newPermision->status = Permission::STATUS_ACTIVE;
                    }

                    $newPermision->save();
                }
            }
        } else {
            Permission::deleteAll();
            GroupPermission::deleteAll();
        }
    }

}