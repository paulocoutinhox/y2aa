<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */

/* @var $model SignUpForm */

use common\components\ui\picker\TimeZonePicker;
use common\helpers\SimpleArrayHelper;
use common\models\domain\Customer;
use common\models\domain\Language;
use frontend\models\form\SignUpForm;
use yii\bootstrap4\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\MaskedInput;

$this->title = Yii::t('frontend', 'Title.Customer.SignUp');
$this->params['breadcrumbs'][] = $this->title;
?>
<main role="main">
    <div class="container">
        <div class="container">
            <h1><?= Html::encode($this->title) ?></h1>

            <p>
                <?= Yii::t('frontend', 'TitleHint.Customer.SignUp') ?>
            </p>

            <br>

            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                    <?= $form->field($model, 'cpf')->widget(MaskedInput::class, [
                        'mask' => '999.999.999-99',
                        'clientOptions' => [
                            'removeMaskOnSubmit' => true,
                            'unmaskAsNumber' => true,
                            'clearMaskOnLostFocus' => true,
                            'autoUnmask' => true,
                        ],
                    ]) ?>

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'mobilePhone')->widget(MaskedInput::class, [
                        'mask' => '(99)[9]9999-9999',
                        'clientOptions' => [
                            'removeMaskOnSubmit' => true,
                            'unmaskAsNumber' => true,
                            'clearMaskOnLostFocus' => true,
                            'autoUnmask' => true,
                        ],
                    ]) ?>

                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'gender')->dropDownList(SimpleArrayHelper::map(Customer::getGenderList()), ['prompt' => '']) ?>

                    <hr>

                    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'value' => '']) ?>

                    <?= $form->field($model, 'repeatPassword')->passwordInput(['maxlength' => true, 'value' => '']) ?>

                    <hr>

                    <?= $form->field($model, 'languageId')->dropDownList(ArrayHelper::map(Language::find()->all(), 'id', 'native_name'), ['prompt' => null]) ?>

                    <?= $form->field($model, 'timezone')->widget(TimeZonePicker::class, [
                        'options' => ['class' => 'form-control'],
                    ]) ?>

                    <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
                        'template' => '<div class="row"><div class="col-lg-8 captcha-field">{input}</div><div class="col-lg-4">{image}</div></div>',
                    ])
                    ?>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('frontend', 'Button.SignUp.Confirm'), ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>

                <div class="col-md-6 col-xs-12">
                    <p>
                        <?= Yii::t('frontend', 'Hint.SignUp.AlreadyRegistered') ?>
                    </p>

                    <a class="btn btn-primary" href="<?= Url::to('/customer/login') ?>">
                        <?= Yii::t('frontend', 'Button.SignUp.Login') ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>
