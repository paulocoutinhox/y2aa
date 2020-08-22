<?php

use common\helpers\SimpleArrayHelper;
use common\models\domain\Log;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\domain\Log */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $areaTitle string */

?>

<?php $this->beginContent('@backend/views/shared/module/moduleContainer.php'); ?>

<?php $form = ActiveForm::begin(); ?>

    <div class="card-header">
        <?= Html::submitButton($model->isNewRecord
            ? Yii::t('backend', 'Button.Create', ['modelClass' => $areaTitle])
            : Yii::t('backend', 'Button.Update', ['modelClass' => $areaTitle]), ['class' => 'btn btn-success']) ?>

        <?= Html::a(Yii::t('backend', 'Button.Back', ['modelClass' => $areaTitle]),
            ['index'], ['class' => 'btn btn-primary']); ?>
    </div>

    <div class="card-body">

        <?= $form->errorSummary($model); ?>

        <?= $form->field($model, 'customer_id')->textInput() ?>

        <?= $form->field($model, 'source')->dropDownList(SimpleArrayHelper::map(Log::getSourceList()), ['prompt' => null]) ?>

        <?= $form->field($model, 'level')->dropDownList(SimpleArrayHelper::map(Log::getLevelList()), ['prompt' => null]) ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    </div>

    <div class="card-footer">
        <?= Html::submitButton($model->isNewRecord
            ? Yii::t('backend', 'Button.Create', ['modelClass' => $areaTitle])
            : Yii::t('backend', 'Button.Update', ['modelClass' => $areaTitle]), ['class' => 'btn btn-success']) ?>

        <?= Html::a(Yii::t('backend', 'Button.Back', ['modelClass' => $areaTitle]),
            ['index'], ['class' => 'btn btn-primary']); ?>
    </div>

<?php ActiveForm::end(); ?>

<?php $this->endContent(); ?>