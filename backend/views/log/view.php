<?php

use common\models\domain\Log;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\domain\Log */
/* @var $areaTitle string */

?>

<?php $this->beginContent('@backend/views/shared/module/moduleContainer.php'); ?>

    <div class="card-header">
        <?= Html::a(Yii::t('backend', 'Button.Delete', ['modelClass' => $areaTitle]), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('backend', 'Message.DeleteConfirm'),
                'method' => 'post',
            ],
        ]) ?>

        <?= Html::a(Yii::t('backend', 'Button.Back', ['modelClass' => $areaTitle]), ['index'], ['class' => 'btn btn-primary']); ?>
    </div>

    <div class="card-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                [
                    'attribute' => 'customer.name',
                    'label' => Yii::t('backend', 'Label.Customer')
                ],
                [
                    'attribute' => 'source',
                    'value' => function ($model, $widget) {
                        $list = Log::getSourceList();

                        if (isset($list[$model->source])) {
                            return $list[$model->source];
                        }

                        return null;
                    }
                ],
                [
                    'attribute' => 'level',
                    'value' => function ($model, $widget) {
                        $list = Log::getLevelList();

                        if (isset($list[$model->level])) {
                            return $list[$model->level];
                        }

                        return null;
                    }
                ],
                'description:ntext',
                'created_at:datetime',
            ],
        ]) ?>
    </div>

<?= $this->endContent() ?>