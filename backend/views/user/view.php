<?php

use common\models\domain\Group;
use common\models\domain\User;
use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\domain\User */
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
                    <?= Yii::t('backend', 'User.Area.TabData') ?>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="#tab-2" class="nav-link" data-toggle="pill" role="tab" aria-controls="tab-2"
                   aria-selected="false" id="pills-tab-2">
                    <?= Yii::t('backend', 'User.Area.TabGroups') ?>
                </a>
            </li>
        </ul>

        <div class="tab-content">

            <div class="tab-pane show active" id="tab-1" role="tabpanel" aria-labelledby="pills-tab-1">

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'name',
                        'email:email',
                        [
                            'attribute' => 'gender',
                            'value' => function ($model, $widget) {
                                $list = User::getGenderList();

                                if (isset($list[$model->gender])) {
                                    return $list[$model->gender];
                                }

                                return null;
                            }
                        ],
                        [
                            'label' => Yii::t('backend', 'Label.Language'),
                            'attribute' => 'language.native_name',
                        ],
                        [
                            'attribute' => 'root',
                            'value' => function ($model, $widget) {
                                $list = User::getRootList();

                                if (isset($list[$model->root])) {
                                    return $list[$model->root];
                                }

                                return null;
                            }
                        ],
                        'timezone',
                        [
                            'attribute' => 'status',
                            'value' => function ($model, $widget) {
                                $list = User::getStatusList();

                                if (isset($list[$model->status])) {
                                    return $list[$model->status];
                                }

                                return null;
                            }
                        ],
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
                ]) ?>
            </div>

            <div class="tab-pane" id="tab-2" role="tabpanel" aria-labelledby="pills-tab-2">
                <?php
                $groups = Group::find()->orderByName()->all();

                if ($groups) {
                    foreach ($groups as $group) {
                        echo($this->render('groupView', ['group' => $group, 'model' => $model]));
                    }
                }
                ?>
            </div>
        </div>
    </div>

<?php $this->endContent(); ?>