<?php

/* @var $this yii\web\View */
/* @var $title string */
/* @var $areaTitle string */
/* @var $viewPath string */
/* @var $containerClass string */
/* @var $breadcrumbs array */
/* @var $model ActiveRecord */
/* @var $filterModel ActiveRecord */

/* @var $dataProvider ActiveDataProvider */

use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

$this->title = $title;

foreach ($breadcrumbs as $breadcrumb) {
    $this->params['breadcrumbs'][] = $breadcrumb;
}
?>

<div class="<?= $containerClass ?>-index">
    <?= $this->render($viewPath . '/report', ['dataProvider' => $dataProvider, 'model' => $model, 'filterModel' => $filterModel, 'areaTitle' => $areaTitle, 'title' => $title]) ?>
</div>

