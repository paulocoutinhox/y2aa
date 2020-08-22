<?php

/* @var $this yii\web\View */

use common\models\domain\GalleryItem;
use yii\bootstrap4\Html;

/* @var $model GalleryItem */

?>
<li class="gallery-item">
    <?= Html::img($model->getUrl()) ?>
</li>
