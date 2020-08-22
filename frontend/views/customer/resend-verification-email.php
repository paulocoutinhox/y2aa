<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */

/* @var $model ResendVerificationEmailForm */

use frontend\models\form\ResendVerificationEmailForm;
use yii\bootstrap4\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;

$this->title = Yii::t('frontend', 'Title.Customer.ResendVerificationEmail');
$this->params['breadcrumbs'][] = $this->title;
?>

<main role="main">
    <div class="container">
        <div class="container">
            <h1><?= Html::encode($this->title) ?></h1>

            <p>
                <?= Yii::t('frontend', 'TitleHint.Customer.ResendVerificationEmail') ?>
            </p>

            <br>

            <div class="row">
                <div class="col-lg-5">
                    <?php $form = ActiveForm::begin(['id' => 'resend-verification-email']); ?>

                    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
                        'template' => '<div class="row"><div class="col-lg-8 captcha-field">{input}</div><div class="col-lg-4">{image}</div></div>',
                    ])
                    ?>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('frontend', 'Button.ResendVerificationEmail.Send'), ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</main>
