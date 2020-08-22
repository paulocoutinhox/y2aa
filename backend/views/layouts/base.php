<?php

use backend\assets\BackendAsset;
use backend\assets\BootboxAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $content string */

$bundle = BackendAsset::register($this);
BootboxAsset::overrideSystemConfirm();

$this->params['body-class'] = array_key_exists('body-class', $this->params) ? $this->params['body-class'] : null;
?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <meta name="theme-color" content="#007bff"/>

        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>

        <link rel="shortcut icon" type="image/ico" href="/favicon.ico"/>
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/manifest.json">

        <script type="text/javascript">
            var backendBaseURL = '<?= Yii::$app->request->baseUrl ?>';
        </script>

        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    </head>
    <?php
    $adminSidebarToggleState = Yii::$app->request->cookies->get('admin-toggle-sidebar-state');
    $adminSidebarClass = ($adminSidebarToggleState == 'closed' ? 'sidebar-collapse' : '');
    $defaultBodyClass = 'sidebar-mini layout-fixed control-sidebar-slide-open accent-lightblue text-sm';

    if (Yii::$app->controller->action->getUniqueId() == 'site/login') {
        $defaultBodyClass = 'accent-navy text-sm';
    }

    echo Html::beginTag('body', [
        'class' => implode(' ', [
            ArrayHelper::getValue($this->params, 'body-class'),
            $defaultBodyClass,
            $adminSidebarClass,
        ]),
    ]) ?>
    <?php $this->beginBody() ?>
    <?= $content ?>
    <?php $this->endBody() ?>
    <?= Html::endTag('body') ?>
    </html>
<?php $this->endPage() ?>