<?php

use common\helpers\SimpleArrayHelper;
use common\models\domain\Group;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\search\GroupSearch */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $buttonCreateLabel string */

?>

<div class="search-filters">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'status')->dropDownList(SimpleArrayHelper::map(Group::getStatusList()), ['prompt' => Yii::t('backend', 'Prompt.All.Male')]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Button.Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('backend', 'Button.Reset'), ['class' => 'btn btn-default']) ?>
        <?= Html::a($buttonCreateLabel, ['create'], ['class' => 'btn btn-success float-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
