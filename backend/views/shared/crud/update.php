<?php

/* @var $this yii\web\View */
/* @var $title string */
/* @var $areaTitle string */
/* @var $viewPath string */
/* @var $containerClass string */
/* @var $showForm boolean */
/* @var $breadcrumbs array */

/* @var $model ActiveRecord */

use yii\db\ActiveRecord;

$this->title = $title;

foreach ($breadcrumbs as $breadcrumb) {
    $this->params['breadcrumbs'][] = $breadcrumb;
}
?>

<div class="<?= $containerClass ?>-update">
    <?php
    if ($showForm) {
        $params = [
            'model' => $model,
            'areaTitle' => $areaTitle,
            'viewPath' => $viewPath,
            'extra' => (empty($extra) ? [] : $extra),
        ];

        if (isset($buttonUpdateLabel)) {
            $params['buttonUpdateLabel'] = $buttonUpdateLabel;
        }

        echo $this->render($viewPath . '/form', $params);
    };
    ?>
</div>

