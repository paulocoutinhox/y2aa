<?php

use common\components\ui\picker\TimeZonePicker;
use common\helpers\SimpleArrayHelper;
use common\models\domain\Group;
use common\models\domain\Language;
use common\models\domain\User;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\domain\User */
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

                <?= $form->errorSummary($model); ?>

                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'status')->dropDownList(SimpleArrayHelper::map(User::getStatusList())) ?>

                <?= $form->field($model, 'gender')->dropDownList(SimpleArrayHelper::map(User::getGenderList()), ['prompt' => '']) ?>

                <?= $form->field($model, 'root')->dropDownList(SimpleArrayHelper::map(User::getRootList()), ['prompt' => '']) ?>

                <hr>

                <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'value' => '']) ?>

                <?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => true, 'value' => '']) ?>

                <hr>

                <?= $form->field($model, 'language_id')->dropDownList(ArrayHelper::map(Language::find()->all(), 'id', 'native_name'), ['prompt' => null]) ?>

                <?= $form->field($model, 'timezone')->widget(TimeZonePicker::class, [
                    'options' => ['class' => 'form-control'],
                ]) ?>


            </div>

            <div class="tab-pane" id="tab-2" role="tabpanel" aria-labelledby="pills-tab-2">

                <?php
                $groups = Group::find()->orderByName()->all();

                if ($groups) {
                    foreach ($groups as $group) {
                        echo($this->render('groupForm', ['group' => $group, 'model' => $model, 'form' => $form]));
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