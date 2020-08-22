<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = Yii::t('frontend', 'Title.App');
?>

<main role="main">
    <div class="container">
        <div class="text-center">
            <h1 class="bd-title" id="content">
                <?= $this->title ?>
            </h1>

            <br/>

            <?= Html::img('@web/images/logo.png', ['class' => 'img-fluid', 'style' => 'max-width: 200px; margin: 0 auto;']) ?>
        </div>
    </div>
</main>