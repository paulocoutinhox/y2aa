<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model \common\models\domain\Group */
/* @var $permission \common\models\domain\Permission */
/* @var $form yii\bootstrap4\ActiveForm */

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
    <?= Html::checkbox("Group[permissions][{$objectId}]", $checked, [
        'id' => "permission_{$objectId}",
        'value' => $objectId,
        'class' => 'form-check-input',
    ]); ?>

    <label class="form-check-label" for="permission_<?= $objectId ?>">
        <?= Yii::t('backend', $permission['description']) ?>
    </label>
</div>
