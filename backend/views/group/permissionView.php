<?php

use common\models\domain\Permission;

/* @var $this yii\web\View */
/* @var $model common\models\domain\Group */
/* @var $permission Permission */

$checked = false;
$objectId = $permission['id'];

if ($model->permissions) {
    if (isset($model->permissions[$objectId])) {
        if ($model->permissions[$objectId] == $objectId) {
            $checked = true;
        }
    }
}
?>
<div class="form-check field_permission_<?= $objectId ?>">
    <div class="checkbox">
        <?= $checked ? '<i class="fa fa-circle text-success"></i>' : '<i class="fa fa-circle text-danger"></i>' ?>
        <?= Yii::t('backend', $permission['description']) ?>
    </div>
</div>
