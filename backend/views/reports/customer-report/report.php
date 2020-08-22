<?php

use common\components\ui\grid\EnumColumn;
use common\models\domain\User;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

/* @var $this yii\web\View */
/* @var $dataProvider ActiveDataProvider */
/* @var $showGridViewFilter boolean */
/* @var $model ActiveRecord */
/* @var $filterModel ActiveRecord */
/* @var $areaTitle string */
/* @var $title string */

$columns = [
    'id',
    'name',
    'email',
    [
        'class' => EnumColumn::class,
        'attribute' => 'status',
        'enum' => User::getStatusList(),
    ],
    'created_at:datetime',
];

$exportMenu = ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $columns,
    'showConfirmAlert' => false,
]);

$pdfHeader = [
    'L' => [
        'content' => $title,
        'font-size' => 8,
        'color' => '#333333',
    ],
    'C' => [
        'content' => '',
        'font-size' => 16,
        'color' => '#333333',
    ],
    'R' => [
        'content' => Yii::t('kvgrid', 'Generated') . ': ' . date("D, d-M-Y g:i a T"),
        'font-size' => 8,
        'color' => '#333333',
    ],
];

$pdfFooter = [
    'L' => [
        'content' => '',
        'font-size' => 8,
        'font-style' => 'B',
        'color' => '#999999',
    ],
    'R' => [
        'content' => '[ {PAGENO} ]',
        'font-size' => 8,
        'font-style' => '',
        'font-family' => 'Helvetica',
        'color' => '#333333',
    ],
    'line' => true,
];

$panelHeadingTemplate = '
<div class="float-right">
    {export}
</div>
<div class="float-left">
    {summary}
</div>
<h3 class="panel-title">
    {title}
</h3>
<div class="clearfix"></div>
';

$panelBeforeTemplate = '
{before}
<div class="clearfix"></div>
';

$panelFooterTemplate = '
{footer}
<div class="clearfix"></div>
';
?>

<?php $this->beginContent('@backend/views/shared/module/moduleContainer.php', ['type' => 'report']); ?>

    <div class="card-body">

        <?php
        echo(GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $filterModel,
            'columns' => $columns,
            'responsive' => true,
            'striped' => true,
            'hover' => false,
            'panel' => [
                'type' => GridView::TYPE_DEFAULT,
                'beforeOptions' => [
                    'class' => ''
                ],
                'afterOptions' => [
                    'class' => ''
                ],
                'footerOptions' => [
                    'class' => ''
                ],
            ],
            'toolbar' => [
                $exportMenu,
            ],
            'export' => [
                'showConfirmAlert' => false,
            ],
            'exportConfig' => [
                GridView::PDF => [
                    'config' => [
                        'methods' => [
                            'SetHeader' => [
                                ['odd' => $pdfHeader, 'even' => $pdfHeader]
                            ],
                            'SetFooter' => [
                                ['odd' => $pdfFooter, 'even' => $pdfFooter]
                            ],
                        ],
                    ],
                ],
                GridView::EXCEL => [],
                GridView::CSV => [],
            ],
            'panelPrefix' => '',
            'panelHeadingTemplate' => $panelHeadingTemplate,
            'panelBeforeTemplate' => $panelBeforeTemplate,
            'panelFooterTemplate' => $panelFooterTemplate,
        ]));
        ?>

    </div>

<?php $this->endContent(); ?>