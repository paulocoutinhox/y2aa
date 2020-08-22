<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $name;
?>

<main role="main">
    <div class="container">
        <div class="text-center">
            <div>
                <a href="<?= Url::to(['/site/index']) ?>">
                    <?= Html::img('@web/images/logo.png', ['class' => 'img-fluid', 'style' => 'max-width: 196px; margin: 0 auto;']) ?>
                </a>
            </div>

            <br>

            <h1 class="bd-title" id="content">
                <?= Html::encode($this->title) ?>
            </h1>

            <br>

            <p class="lead">
                <?= nl2br(Html::encode($message)) ?>

                <br>

                <?= Yii::t('frontend', 'Error.App.Message') ?>
            </p>

            <br>

            <a class="btn btn-primary btn-lg" href="<?= Url::to(['/site/index']) ?>">
                <?= Yii::t('frontend', 'Button.App.Error') ?>
            </a>
        </div>
    </div>
</main>
