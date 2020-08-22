<?php

/* @var $this yii\web\View */
/* @var $title string */
/* @var $areaTitle string */
/* @var $viewPath string */
/* @var $content string */
/* @var $containerClass string */
/* @var $breadcrumbs array */

/* @var $model ActiveRecord */

use yii\db\ActiveRecord;

$this->title = $title;

foreach ($breadcrumbs as $breadcrumb) {
    $this->params['breadcrumbs'][] = $breadcrumb;
}
?>

<div class="<?= $containerClass ?>-view">
    <?php
    $params = [
        'model' => $model,
        'areaTitle' => $areaTitle,
        'viewPath' => $viewPath,
        'extra' => (empty($extra) ? [] : $extra),
    ];

    if (isset($buttonCreateLabel)) {
        $params['buttonCreateLabel'] = $buttonCreateLabel;
    }

    if (isset($buttonUpdateLabel)) {
        $params['buttonUpdateLabel'] = $buttonUpdateLabel;
    }

    echo $this->render($viewPath . '/view', $params);
    ?>
</div>

