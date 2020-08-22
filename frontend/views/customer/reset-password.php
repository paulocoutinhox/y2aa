<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */

/* @var $model ResetPasswordForm */

use frontend\models\form\ResetPasswordForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('frontend', 'Title.Customer.ResetPassword');
$this->params['breadcrumbs'][] = $this->title;
?>

<main role="main">
    <div class="container">
        <div class="container">
            <h1><?= Html::encode($this->title) ?></h1>

            <p>
                <?= Yii::t('frontend', 'TitleHint.Customer.ResetPassword') ?>
            </p>

            <br>

            <div class="row">
                <div class="col-lg-5">
                    <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

                    <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('frontend', 'Button.Customer.ResetPassword.Save'), ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</main>
