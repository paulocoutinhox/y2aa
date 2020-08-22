<?php

/* @var $this View */

/* @var $content string */

use frontend\assets\FrontendAsset;
use yii\helpers\Html;
use yii\web\View;

FrontendAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode(empty($this->title) ? Yii::$app->name : $this->title) ?></title>
    <?php $this->head() ?>

    <link rel="shortcut icon" type="image/ico" href="/favicon.ico"/>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#007bff">

    <?= $this->render('/shared/head.php') ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody(); ?>

<?= $this->render('/shared/header.php') ?>

<?= $this->render('/shared/breadcrumbs.php', ['params' => $this->params]) ?>

<?= $content ?>

<?= $this->render('/shared/footer.php') ?>

<?= $this->render('/shared/plugins.php') ?>

<?= $this->render('/shared/modal.php') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
