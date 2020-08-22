<?php

use common\models\domain\Group;
use common\models\domain\User;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model User */
/* @var $group Group */
/* @var $form yii\bootstrap4\ActiveForm */

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
    <?= Html::checkbox("User[groups][{$objectId}]", $checked, [
        'id' => "group_{$objectId}",
        'value' => $objectId,
        'class' => 'form-check-input',
    ]); ?>

    <label class="form-check-label" for="group_<?= $objectId ?>">
        <?= Yii::t('backend', $group['name']) ?>
    </label>
</div>
