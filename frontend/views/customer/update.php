<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */

/* @var $model Customer */

use common\components\ui\picker\TimeZonePicker;
use common\helpers\SimpleArrayHelper;
use common\models\domain\Customer;
use common\models\domain\Language;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

$this->title = Yii::t('frontend', 'Title.Customer.Profile');
$this->params['breadcrumbs'][] = $this->title;
?>

<main role="main">
    <div class="container">
        <h1 class="bd-title">
            <?= Html::encode($this->title) ?>
        </h1>

        <div class="row">
            <div class="col-12 col-lg-3">
                <?= $this->render('/shared/customer-menu.php') ?>
            </div>
            <div class="col-12 col-lg-9 mt-4 mt-lg-0">
                <div class="card">
                    <div class="card-header">
                        <strong>
                            <?= Yii::t('frontend', 'Title.Customer.Profile.Data') ?>
                        </strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-lg-12 col-xl-12">
                                <?php $form = ActiveForm::begin(); ?>

                                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                                <?= $form->field($model, 'cpf')->widget(MaskedInput::class, [
                                    'mask' => '999.999.999-99',
                                    'clientOptions' => [
                                        'removeMaskOnSubmit' => true,
                                        'unmaskAsNumber' => true,
                                        'clearMaskOnLostFocus' => true,
                                        'autoUnmask' => true,
                                    ],
                                ]) ?>

                                <div class="card-divider"></div>

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

                                <div class="card-divider"></div>

                                <?= $form->field($model, 'gender')->dropDownList(SimpleArrayHelper::map(Customer::getGenderList()), ['prompt' => '']) ?>

                                <div class="card-divider"></div>

                                <?= $form->field($model, 'language_id')->dropDownList(ArrayHelper::map(Language::find()->all(), 'id', 'native_name'), ['prompt' => null]) ?>

                                <?= $form->field($model, 'timezone')->widget(TimeZonePicker::class, [
                                    'options' => ['class' => 'form-control'],
                                ]) ?>

                                <div class="card-divider"></div>

                                <?= $form->field($model, 'obs')->textarea(['rows' => 4]) ?>

                                <div class="card-divider"></div>

                                <?= Yii::t('common', 'Model.LoggedAt') ?>
                                <br>
                                <p>
                                    <?= Yii::$app->formatter->asDatetime($model->logged_at) ?>
                                </p>

                                <br>

                                <div class="form-group">
                                    <?= Html::submitButton(Yii::t('frontend', 'Button.Customer.Profile.Form.Confirm'), ['class' => 'btn btn-primary']) ?>
                                </div>

                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
