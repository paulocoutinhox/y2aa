<?php

use common\components\ui\picker\TimeZonePicker;
use common\helpers\SimpleArrayHelper;
use common\models\domain\Customer;
use common\models\domain\Language;
use common\models\util\BrazilUtil;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model common\models\domain\Customer */
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

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'cpf')->widget(MaskedInput::class, [
            'mask' => '999.999.999-99',
            'clientOptions' => [
                'removeMaskOnSubmit' => true,
                'unmaskAsNumber' => true,
                'clearMaskOnLostFocus' => true,
                'autoUnmask' => true,
            ],
        ]) ?>

        <?= $form->field($model, 'mobile_phone')->widget(MaskedInput::class, [
            'mask' => '(99)[9]9999-9999',
            'clientOptions' => [
                'removeMaskOnSubmit' => true,
                'unmaskAsNumber' => true,
                'clearMaskOnLostFocus' => true,
                'autoUnmask' => true,
            ],
        ]) ?>

        <?= $form->field($model, 'home_phone')->widget(MaskedInput::class, [
            'mask' => '(99)9999-9999',
            'clientOptions' => [
                'removeMaskOnSubmit' => true,
                'unmaskAsNumber' => true,
                'clearMaskOnLostFocus' => true,
                'autoUnmask' => true,
            ],
        ]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'gender')->dropDownList(SimpleArrayHelper::map(Customer::getGenderList()), ['prompt' => '']) ?>

        <?= $form->field($model, 'status')->dropDownList(SimpleArrayHelper::map(Customer::getStatusList()), ['prompt' => null]) ?>

        <?php if ($model->isNewRecord): ?>

            <hr>

            <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'value' => '']) ?>

            <?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => true, 'value' => '']) ?>

        <?php endif; ?>

        <hr>

        <?= $form->field($model, 'language_id')->dropDownList(ArrayHelper::map(Language::find()->onlyAllowedLanguage()->all(), 'id', 'native_name'), ['prompt' => null]) ?>

        <?= $form->field($model, 'timezone')->widget(TimeZonePicker::class, [
            'options' => ['class' => 'form-control'],
        ]) ?>

        <?= $form->field($model, 'obs')->textarea(['rows' => 4]) ?>

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