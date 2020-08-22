<?php

/* @var $this yii\web\View */
/* @var $title string */
/* @var $areaTitle string */
/* @var $viewPath string */
/* @var $containerClass string */
/* @var $showCreateButton boolean */
/* @var $breadcrumbs array */
/* @var $showFilterForm boolean */
/* @var $showGridView boolean */
/* @var $showGridViewFilter boolean */
/* @var $searchModel ActiveRecord */
/* @var $filterModel ActiveRecord */

/* @var $dataProvider ActiveDataProvider */

use yii\bootstrap4\Html;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

$this->title = $title;
$buttonCreateLabel = isset($buttonCreateLabel) ? $buttonCreateLabel : Yii::t('backend', 'Button.Create', ['modelClass' => $areaTitle]);

foreach ($breadcrumbs as $breadcrumb) {
    $this->params['breadcrumbs'][] = $breadcrumb;
}
?>

<?php $this->beginContent('@backend/views/shared/module/moduleContainer.php'); ?>

<div class="p-3">

    <?php
    // show search filter form
    if ($showFilterForm) {
        echo $this->render($viewPath . '/filters', ['model' => $searchModel, 'buttonCreateLabel' => $buttonCreateLabel]);
    }
    ?>

    <p>
        <?php
        // show create button
        if ($showCreateButton) {
            echo Html::a($buttonCreateLabel, ['create'], ['class' => 'btn btn-success']);
        }
        ?>
    </p>

    <?php
    // show grid view
    if ($showGridView) {
        echo $this->render($viewPath . '/grid', ['dataProvider' => $dataProvider, 'filterModel' => $filterModel, 'showGridViewFilter' => $showGridViewFilter]);
    };
    ?>

</div>

<?php $this->endContent(); ?>

