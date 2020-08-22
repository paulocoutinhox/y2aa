<?php

/* @var $this yii\web\View */
/* @var $title string */
/* @var $areaTitle string */
/* @var $viewPath string */
/* @var $containerClass string */
/* @var $showForm boolean */
/* @var $breadcrumbs array */
/* @var $extra array */

/* @var $model ActiveRecord */

use yii\db\ActiveRecord;

$this->title = $title;

foreach ($breadcrumbs as $breadcrumb) {
    $this->params['breadcrumbs'][] = $breadcrumb;
}
?>

<div class="<?= $containerClass ?>-create">
    <?php
    if ($showForm) {
        $params = [
            'model' => $model,
            'areaTitle' => $areaTitle,
            'viewPath' => $viewPath,
            'extra' => (empty($extra) ? [] : $extra),
        ];

        if (isset($buttonCreateLabel)) {
            $params['buttonCreateLabel'] = $buttonCreateLabel;
        }

        echo $this->render($viewPath . '/form', $params);
    };
    ?>
</div>

