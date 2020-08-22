<?php

use kartik\grid\GridView;
use yii\db\ActiveRecord;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $showGridViewFilter boolean */
/* @var $filterModel ActiveRecord */

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => ($showGridViewFilter ? $filterModel : null),
    'columns' => [
        'id',
        'key',
        'value',
        'description',
        'created_at:datetime',
        'updated_at:datetime',
        [
            'class' => 'kartik\grid\ActionColumn',
            'header' => '',
            'template' => '<div class="grid-action-column">{view}</div>',
        ],
        [
            'class' => 'kartik\grid\ActionColumn',
            'header' => '',
            'template' => '<div class="grid-action-column">{update}</div>',
        ]
    ],
]);
