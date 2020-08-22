<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\domain\Preference */
/* @var $areaTitle string */

?>
<?php $this->beginContent('@backend/views/shared/module/moduleContainer.php'); ?>

    <div class="card-header">
        <?= Html::a(Yii::t('backend', 'Button.Update', ['modelClass' => $areaTitle]), ['update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('backend', 'Button.Back', ['modelClass' => $areaTitle]), ['index'], ['class' => 'btn btn-primary']); ?>
    </div>

    <div class="card-body">

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'key',
                'value',
                'description',
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]) ?>
    </div>

<?= $this->endContent() ?>