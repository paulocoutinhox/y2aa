<?php

use common\models\domain\Customer;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\domain\Customer */
/* @var $areaTitle string */

?>

<?php $this->beginContent('@backend/views/shared/module/moduleContainer.php'); ?>

    <div class="card-header">
        <?= Html::a(Yii::t('backend', 'Button.Create', ['modelClass' => $areaTitle]), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('backend', 'Button.Update', ['modelClass' => $areaTitle]), ['update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
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
                'name',
                [
                    'attribute' => 'cpf',
                    'format' => 'raw',
                    'value' => function ($model) {

                        return Yii::$app->formatter->asCPF($model->cpf);

                    },
                ],
                [
                    'attribute' => 'mobile_phone',
                    'format' => 'raw',
                    'value' => function ($model) {

                        return Yii::$app->formatter->asPhone($model->mobile_phone);

                    },
                ],
                [
                    'attribute' => 'home_phone',
                    'format' => 'raw',
                    'value' => function ($model) {

                        return Yii::$app->formatter->asPhone($model->home_phone);

                    },
                ],
                'email',
                [
                    'attribute' => 'gender',
                    'value' => function ($model, $widget) {
                        $list = Customer::getGenderList();

                        if (isset($list[$model->gender])) {
                            return $list[$model->gender];
                        }

                        return null;
                    }
                ],
                [
                    'attribute' => 'status',
                    'value' => function ($model, $widget) {
                        $list = Customer::getStatusList();

                        if (isset($list[$model->status])) {
                            return $list[$model->status];
                        }

                        return null;
                    }
                ],
                [
                    'label' => Yii::t('backend', 'Label.Language'),
                    'attribute' => 'language.native_name',
                ],
                'timezone',
                'obs:ntext',
                'logged_at:datetime',
                'created_at:datetime',
                'updated_at:datetime',
                [
                    'attribute' => 'avatar_path',
                    'format' => 'raw',
                    'value' => function ($model, $widget) {
                        return Html::img($model->getAvatar('@web/images/profile-default.png'), [
                            'class' => 'img-fluid img-mw-100',
                        ]);
                    }
                ],
            ],
        ]);
        ?>
    </div>

<?= $this->endContent() ?>