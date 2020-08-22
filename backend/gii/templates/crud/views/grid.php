<?php

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use <?php echo $generator->indexWidgetType === 'grid' ? "kartik\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
use yii\db\ActiveRecord;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $showGridViewFilter boolean */
/* @var $filterModel \yii\db\ActiveRecord */

<?php if ($generator->indexWidgetType === 'grid'): ?>
echo GridView::widget([
    'dataProvider' => $dataProvider,
    <?php echo !empty($generator->searchModelClass) ? "'filterModel' => (\$showGridViewFilter ? \$filterModel : null),\n    'columns' => [\n" : "'columns' => [\n"; ?>
<?php
    $count = 0;
    if (($tableSchema = $generator->getTableSchema()) === false) {
        foreach ($generator->getColumnNames() as $name) {
            if (++$count < 6) {
                echo "        '" . $name . "',\n";
            } else {
                echo "        // '" . $name . "',\n";
            }
        }
    } else {
        foreach ($tableSchema->columns as $column) {
            $format = $generator->generateColumnFormat($column);
            if (++$count < 6) {
                echo "        '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
            } else {
                echo "        '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
            }
        }
    }
?>
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
<?php else: ?>
<?php echo "echo " ?>ListView::widget([
    'dataProvider' => $dataProvider,
    'itemOptions' => ['class' => 'item'],
    'itemView' => function ($model, $key, $index, $widget) {
        return Html::a(Html::encode($model-><?php echo $nameAttribute ?>), ['view', <?php echo $urlParams ?>]);
    },
])
<?php endif; ?>