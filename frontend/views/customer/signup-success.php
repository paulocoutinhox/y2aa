<?php

/* @var $this yii\web\View */

/* @var $form yii\bootstrap4\ActiveForm */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('frontend', 'Title.Customer.SignUp');
$this->params['breadcrumbs'][] = $this->title;
?>

<main role="main">
    <div class="container">
        <div class="text-center">
            <h1 class="bd-title">
                <?= Html::encode($this->title) ?>
            </h1>

            <br>

            <?= Html::img('@web/images/ico-success.png', ['style' => 'width: 128px;']) ?>

            <br>
            <br>

            <?php
            if (Yii::$app->params['customerHasSignUpVerification']) {
                echo(Yii::t('frontend', 'Message.SignUp.WithVerification.Success'));
            } else {
                echo(Yii::t('frontend', 'Message.SignUp.Success'));
            }
            ?>

            <br>
            <br>

            <? if (Yii::$app->params['customerHasSignUpVerification']): ?>
                <p>
                    <?= Yii::t('frontend', 'Hint.SignUp.ResendVerificationEmail') ?>
                </p>
                <a class="btn btn-primary btn-sm" href="/customer/resend-verification-email">
                    <?= Yii::t('frontend', 'Button.Customer.SendVerificationEmail') ?>
                </a>
                <br>
                <br>
            <? else: ?>
                <a class="btn btn-primary btn-sm" href="<?= Url::home() ?>">
                    <?= Yii::t('frontend', 'Button.GoToHome') ?>
                </a>
                <br>
                <br>
            <? endif; ?>
        </div>
    </div>
</main>
