<?php
$containerClass = 'card';
$type = (isset($type) ? $type : null);

if ($type == 'report') {
    $containerClass .= ' card-report';
}

$pageClass = 'page';

if (Yii::$app->module) {
    $pageClass .= '-' . Yii::$app->module->getUniqueId();
}

if (Yii::$app->controller->action) {
    $pageClass .= '-' . Yii::$app->controller->action->getUniqueId();
}

$pageClass = str_replace('/', '-', $pageClass);
?>

<div class="<?= $pageClass ?>">
    <div class="<?= $containerClass ?>">
        <?= (isset($content) ? $content : null) ?>
    </div>
</div>