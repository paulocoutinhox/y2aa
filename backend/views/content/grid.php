<?php

use common\components\ui\grid\EnumColumn;
use common\models\domain\Content;
use common\models\domain\Language;
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
        'title',
        [
            'class' => EnumColumn::class,
            'attribute' => 'tag',
            'enum' => Content::getTagList(),
        ],
        [
            'attribute' => 'language.name',
            'label' => Yii::t('backend', 'Label.Language'),
            'filter' => Html::activeDropDownList($filterModel, 'language_id', ArrayHelper::map(Language::find()->onlyAllowedLanguage()->asArray()->all(), 'id', 'name'), ['class' => 'form-control', 'prompt' => '']),
        ],
        [
            'class' => EnumColumn::class,
            'attribute' => 'status',
            'enum' => Content::getStatusList(),
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
