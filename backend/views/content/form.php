<?php

use common\helpers\SimpleArrayHelper;
use common\models\domain\Content;
use common\models\domain\Language;
use vova07\imperavi\Widget;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\domain\Content */
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

        <?= $form->errorSummary($model); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'tag')->dropDownList(SimpleArrayHelper::map(Content::getTagList())) ?>

        <?= $form->field($model, 'content')->widget(
            Widget::class,
            [
                'settings' => [
                    'lang' => 'pt_br',
                    'plugins' => ['imagemanager', 'fullscreen', 'fontcolor', 'video'],
                    'minHeight' => 200,
                    'imageUpload' => Yii::$app->urlManager->createUrl(['/content/upload-image']),
                    'imageManagerJson' => Url::to(['/content/get-images']),
                ]
            ]
        ) ?>

        <?= $form->field($model, 'language_id')->dropDownList(ArrayHelper::map(Language::find()->onlyAllowedLanguage()->all(), 'id', 'name'), ['prompt' => '']) ?>

        <?= $form->field($model, 'status')->dropDownList(SimpleArrayHelper::map(Content::getStatusList()), ['prompt' => null]) ?>

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