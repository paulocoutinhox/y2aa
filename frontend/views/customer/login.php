<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */

/* @var $model LoginForm */

use frontend\models\form\LoginForm;
use yii\bootstrap4\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('frontend', 'Title.Customer.Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<main role="main">
    <div class="container">
        <h1 class="bd-title"><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Yii::t('frontend', 'TitleHint.Customer.Login') ?>
        </p>

        <br>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12">
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
                    'template' => '<div class="row"><div class="col-lg-8 captcha-field">{input}</div><div class="col-lg-4">{image}</div></div>',
                ])
                ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div style="color:#999; margin:1em 0">
                    <?= Yii::t('frontend', 'Hint.Login.ForgotPassword') ?>
                    <?= Html::a(Yii::t('frontend', 'Button.Login.ResetPassword'), ['/customer/request-password-reset']) ?>
                    .
                </div>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('frontend', 'Button.Login.Confirm'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>

            <div class="col-lg-6 col-md-6 col-xs-12">
                <p>
                    <?= Yii::t('frontend', 'Hint.Login.NotRegistered') ?>
                </p>

                <a class="btn btn-primary" href="<?= Url::to('/customer/signup') ?>">
                    <?= Yii::t('frontend', 'Button.Login.SignUp') ?>
                </a>
            </div>
        </div>
    </div>
</main>