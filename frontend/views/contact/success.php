<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = Yii::t('frontend', 'Title.Contact.Success');
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

            <?= Yii::t('frontend', 'Message.Contact.Success') ?>
        </div>
    </div>
</main>