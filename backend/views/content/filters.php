<?php

use common\helpers\SimpleArrayHelper;
use common\models\domain\Content;
use common\models\domain\Language;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\search\ContentSearch */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $buttonCreateLabel string */

?>

<div class="search-filters">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'language_id')->dropDownList(ArrayHelper::map(Language::find()->onlyAllowedLanguage()->all(), 'id', 'name'), ['prompt' => Yii::t('backend', 'Prompt.All.Male')]) ?>

    <?= $form->field($model, 'status')->dropDownList(SimpleArrayHelper::map(Content::getStatusList()), ['prompt' => Yii::t('backend', 'Prompt.All.Male')]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Button.Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('backend', 'Button.Reset'), ['class' => 'btn btn-default']) ?>
        <?= Html::a($buttonCreateLabel, ['create'], ['class' => 'btn btn-success float-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
