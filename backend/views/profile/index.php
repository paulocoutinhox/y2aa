<?php

/* @var $this yii\web\View */

/* @var $model common\models\domain\User */

use common\components\ui\picker\TimeZonePicker;
use common\models\domain\Language;
use common\models\domain\User;
use trntv\filekit\widget\Upload;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;

$areaTitle = Yii::t('backend', 'Profile.Area.Title');

$this->title = $areaTitle;
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginContent('@backend/views/shared/module/moduleContainer.php'); ?>

<?php $form = ActiveForm::begin(); ?>

    <div class="card-header">
        <?= Html::submitButton(Yii::t('backend', 'Button.Confirm'), ['class' => 'btn btn-success']) ?>
    </div>

    <div class="card-body">
        <?= $form->field($model, 'avatar')->widget(Upload::class, [
            'url' => ['avatar-upload']
        ]) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

        <?= $form->field($model, 'gender')->dropDownlist([
            User::GENDER_MALE => Yii::t('common', 'Gender.Male'),
            User::GENDER_FEMALE => Yii::t('common', 'Gender.Female'),
        ], [
            'prompt' => Yii::t('backend', 'DropDown.Empty'),
        ]);
        ?>

        <hr>

        <?= $form->field($model, 'language_id')->dropDownList(ArrayHelper::map(Language::find()->all(), 'id', 'native_name'), ['prompt' => null]) ?>

        <?= $form->field($model, 'timezone')->widget(TimeZonePicker::class, [
            'options' => ['class' => 'form-control'],
        ])
        ?>

        <hr>

        <?= $form->field($model, 'password')->passwordInput(['maxlength' => 30]) ?>

        <?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => 30]) ?>
    </div>

    <div class="card-footer">
        <?= Html::submitButton(Yii::t('backend', 'Button.Confirm'), ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

<?php $this->endContent(); ?>