<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

/* @var $exception Exception */

use yii\helpers\Html;

$this->context->layout = (Yii::$app->user->isGuest ? 'base' : 'main');
$this->title = $name;
?>

<div class="error-page">
    <div class="error-content">
        <h3>
            <i class="fas fa-exclamation-triangle text-danger"></i>
            <?= Html::encode($message) ?>
        </h3>

        <br>

        <p>
            <?= nl2br(Yii::t('backend', 'Site.Error.MessageLine1')) ?>
        </p>

        <p>
            <?= nl2br(Yii::t('backend', 'Site.Error.MessageLine2')) ?>
        </p>

        <br>

        <?php if (Yii::$app->user->isGuest): ?>
            <p>
                <?= Html::a(Yii::t('backend', 'Button.LoginFromError'), ['/site/login'], ['class' => 'btn btn-block btn-danger']) ?>
            </p>
        <?php endif; ?>

        <p>
            <?= Html::a(Yii::t('backend', 'Button.Back'), ['/site/index'], ['class' => 'btn btn-block btn-danger']) ?>
        </p>
    </div>
</div>
