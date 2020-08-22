<?php

use common\models\domain\Group;
use common\models\domain\Permission;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\domain\Group */
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

        <ul class="nav nav-pills mb-3" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="#tab-1" class="nav-link active" data-toggle="pill" role="tab" aria-controls="tab-1"
                   aria-selected="true" id="pills-tab-1">
                    <?= Yii::t('backend', 'Group.Area.TabData') ?>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="#tab-2" class="nav-link" data-toggle="pill" role="tab" aria-controls="tab-2"
                   aria-selected="false" id="pills-tab-2">
                    <?= Yii::t('backend', 'Group.Area.TabPermissions') ?>
                </a>
            </li>
        </ul>

        <div class="tab-content">

            <div class="tab-pane show active" id="tab-1" role="tabpanel" aria-labelledby="pills-tab-1">

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        [
                            'attribute' => 'name',
                            'value' => function ($model, $widget) {
                                return Yii::t('backend', $model->name);
                            }
                        ],
                        [
                            'attribute' => 'status',
                            'value' => function ($model, $widget) {
                                $list = Group::getStatusList();

                                if (isset($list[$model->status])) {
                                    return $list[$model->status];
                                }

                                return null;
                            }
                        ],
                        'created_at:datetime',
                        'updated_at:datetime',
                    ],
                ]) ?>
            </div>


            <div class="tab-pane" id="tab-2" role="tabpanel" aria-labelledby="pills-tab-2">

                <?php
                $permissions = Permission::find()->orderByActionGroupAndAction()->all();
                $lastActionGroup = '';
                $isFirstActionGroup = true;


                if ($permissions) {
                    foreach ($permissions as $permission) {
                        if ($lastActionGroup != $permission['action_group']) {
                            $lastActionGroup = $permission['action_group'];

                            if ($isFirstActionGroup) {
                                $isFirstActionGroup = false;
                            } else {
                                echo '<hr>';
                            }

                            ?>

                            <p>
                            <h4>
                                <?= Yii::t('backend', $permission['action_group']) ?>
                            </h4>
                            </p>

                            <?php
                        }

                        echo $this->render('permissionView', ['permission' => $permission, 'model' => $model]);
                    }
                }
                ?>

            </div>

        </div>

    </div>

    <div class="card-footer">
        <?= Html::submitButton($model->isNewRecord
            ? Yii::t('backend', 'Button.Create', ['modelClass' => $areaTitle])
            : Yii::t('backend', 'Button.Update', ['modelClass' => $areaTitle]), ['class' => 'btn btn-success']) ?>

        <?= Html::a(Yii::t('backend', 'Button.Back', ['modelClass' => $areaTitle]),
            ['index'], ['class' => 'btn btn-primary']); ?>
    </div>

<?php $this->endContent(); ?>