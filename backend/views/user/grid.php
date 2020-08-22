<?php

use common\components\ui\grid\EnumColumn;
use common\models\domain\User;
use kartik\grid\GridView;
use yii\bootstrap4\Html;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

/* @var $this yii\web\View */
/* @var $dataProvider ActiveDataProvider */
/* @var $showGridViewFilter boolean */
/* @var $filterModel ActiveRecord */

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => ($showGridViewFilter ? $filterModel : null),
    'columns' => [
        'id',
        [
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
            'headerOptions' => ['class' => 'text-center'],
            'value' => function ($model, $widget) {
                return '<img src="' . $model->getAvatar(Yii::getAlias('@web/images/profile-default.png')) . '" class="img-mw-30" />';
            }
        ],
        'name',
        'email',
        [
            'class' => EnumColumn::class,
            'attribute' => 'status',
            'enum' => User::getStatusList(),
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
    ]
]);