<?php

use common\helpers\SimpleArrayHelper;
use common\models\domain\Group;
use common\models\domain\Permission;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\domain\Group */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $areaTitle string */

?>

<?php $this->beginContent('@backend/views/shared/module/moduleContainer.php'); ?>

<?php $form = ActiveForm::begin(); ?>

    <div class="card-header">
        <?= Html::submitButton($model->isNewRecord
            ? Yii::t('backend', 'Button.Create', ['modelClass' => $areaTitle])
            : Yii::t('backend', 'Button.Update', ['modelClass' => $areaTitle]), ['class' => 'btn btn-success']) ?>

        <?= Html::a(Yii::t('backend', 'Button.Back', ['modelClass' => $areaTitle]),
            ['index'], ['class' => 'btn btn-primary']); ?>
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

                <?= $form->errorSummary($model); ?>

                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'status')->dropDownList(SimpleArrayHelper::map(Group::getStatusList()), ['prompt' => null]) ?>

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

                        echo $this->render('permissionForm', ['permission' => $permission, 'model' => $model, 'form' => $form]);
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

<?php ActiveForm::end(); ?>

<?php $this->endContent(); ?>