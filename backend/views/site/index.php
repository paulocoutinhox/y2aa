<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = \Yii::t('backend', 'Title.Site.Index');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginContent('@backend/views/shared/module/moduleContainer.php'); ?>
    <div class="card-header">
        <h3 class="card-title">
            <?= $this->title ?>
        </h3>
    </div>
    <div class="p-3 text-center">
        <?= Html::img('@web/images/logo.png', ['style' => 'max-width: 150px;']); ?>
    </div>
<?php $this->endContent(); ?>