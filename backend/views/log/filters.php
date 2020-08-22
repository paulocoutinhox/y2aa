<?php

use common\helpers\SimpleArrayHelper;
use common\models\domain\Log;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\search\LogSearch */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $buttonCreateLabel string */

?>

<div class="search-filters">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'customer_id') ?>

    <?= $form->field($model, 'source')->dropDownList(SimpleArrayHelper::map(Log::getSourceList()), ['prompt' => Yii::t('backend', 'Prompt.All.Female')]) ?>

    <?= $form->field($model, 'level')->dropDownList(SimpleArrayHelper::map(Log::getLevelList()), ['prompt' => Yii::t('backend', 'Prompt.All.Male')]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Button.Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('backend', 'Button.Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
