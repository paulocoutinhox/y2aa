<?php

use common\components\ui\grid\EnumColumn;
use common\models\domain\Customer;
use common\models\domain\Log;
use kartik\grid\GridView;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
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
            'attribute' => 'customer.name',
            'label' => Yii::t('backend', 'Label.Customer'),
            'filter' => Html::activeDropDownList($filterModel, 'customer_id', ArrayHelper::map(Customer::find()->asArray()->all(), 'id', 'name'), ['class' => 'form-control', 'prompt' => '']),
        ],
        [
            'class' => EnumColumn::class,
            'attribute' => 'source',
            'enum' => Log::getSourceList(),
        ],
        [
            'class' => EnumColumn::class,
            'attribute' => 'level',
            'enum' => Log::getLevelList(),
        ],
        'description',
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
