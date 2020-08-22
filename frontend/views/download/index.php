<?php

/* @var $this yii\web\View */

/* @var $system string */


use yii\bootstrap4\Html;
use yii\helpers\Url;

$this->title = Yii::t('frontend', 'Title.Download');

$this->params['breadcrumbs'][] = $this->title;
?>

<main role="main">
    <div class="container">
        <div class="text-center">
            <h1 class="bd-title">
                <?= Html::encode($this->title) ?>
            </h1>

            <?php if ($system == null || $system == 'android'): ?>
                <div class="row" style="margin: 50px 0;">
                    <a href="<?= Url::to(Yii::$app->params['androidAppUrl']) ?>" style="margin: 0 auto;">
                        <?= Html::img('@web/images/google-play-badge.png', ['class' => 'img-fluid', 'style' => 'max-width: 260px;']) ?>
                    </a>
                </div>
            <?php endif; ?>

            <?php if ($system == null || $system == 'ios'): ?>
                <div class="row" style="margin: 50px 0;">
                    <a href="<?= Url::to(Yii::$app->params['iosAppUrl']) ?>" style="margin: 0 auto;">
                        <?= Html::img('@web/images/apple-app-store-badge.png', ['class' => 'img-fluid', 'style' => 'max-width: 260px;']) ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>