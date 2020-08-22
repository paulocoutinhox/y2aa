<?php

/* @var $this yii\web\View */
/* @var $form ActiveForm */

/* @var $model ContactForm */

use frontend\models\form\ContactForm;
use yii\bootstrap4\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;

$this->title = Yii::t('frontend', 'Title.Contact');
$this->params['breadcrumbs'][] = $this->title;
?>

<main role="main">
    <div class="container">
        <h1 class="bd-title">
            <?= Html::encode($this->title) ?>
        </h1>

        <p class="lead">
            <?= Yii::t('frontend', 'TitleHint.Contact') ?>
        </p>

        <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

        <?= $form->field($model, 'name')->textInput() ?>

        <?= $form->field($model, 'email')->textInput() ?>

        <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
            'template' => '<div class="row"><div class="col-lg-8 captcha-field">{input}</div><div class="col-lg-4">{image}</div></div>',
        ])
        ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('frontend', 'Button.Contact.Submit'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</main>
