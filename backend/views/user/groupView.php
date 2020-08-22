<?php

/* @var $this yii\web\View */
/* @var $model User */

/* @var $group Group */

use common\models\domain\Group;
use common\models\domain\User;

$checked = false;
$objectId = $group['id'];

if ($model->groups) {
    if (isset($model->groups[$objectId])) {
        if ($model->groups[$objectId] == $objectId) {
            $checked = true;
        }
    }
}
?>
<div class="form-check field_group_<?= $objectId ?>">
    <div class="checkbox">
        <?= $checked ? '<i class="fa fa-circle text-success"></i>' : '<i class="fa fa-circle text-danger"></i>' ?>
        <?= Yii::t('backend', $group['name']) ?>
    </div>
</div>
