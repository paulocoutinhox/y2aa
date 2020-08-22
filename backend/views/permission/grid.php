<?php

use common\components\ui\grid\EnumColumn;
use common\models\domain\Permission;
use kartik\grid\GridView;
use yii\db\ActiveRecord;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $showGridViewFilter boolean */
/* @var $filterModel ActiveRecord */

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => ($showGridViewFilter ? $filterModel : null),
    'columns' => [
        'id',
        [
            'attribute' => 'description',
            'value' => function ($model) {
                return Yii::t('backend', $model->description);
            }
        ],
        'action',
        [
            'attribute' => 'action_group',
            'value' => function ($model) {
                return Yii::t('backend', $model->action_group);
            }
        ],
        [
            'class' => EnumColumn::class,
            'attribute' => 'status',
            'enum' => Permission::getStatusList(),
        ],
        'created_at:datetime',
        [
            'class' => 'kartik\grid\ActionColumn',
            'header' => '',
            'template' => '<div class="grid-action-column">{view}</div>',
        ],
        [
            'class' => 'kartik\grid\ActionColumn',
            'header' => '',
            'template' => '<div class="grid-action-column">{update}</div>',
        ],
        [
            'class' => 'kartik\grid\ActionColumn',
            'header' => '',
            'template' => '<div class="grid-action-column">{delete}</div>',
            'buttons' => [
                'delete' => function ($url, $model) {
                    return Html::a('<span class="fas fa-trash-alt"></span>', ['delete', 'id' => $model->id], [
                        'data' => [
                            'confirm' => Yii::t('backend', 'Message.DeleteConfirm'),
                            'method' => 'post',
                        ],
                    ]);
                }
            ]
        ]
    ],
]);
