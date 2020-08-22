<?php
/**
 * @var $this yii\web\View
 * @var $model LoginForm
 */

use backend\models\form\LoginForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('backend', 'Title.User.Login');
$this->params['breadcrumbs'][] = $this->title;
$this->params['body-class'] = 'login-page';
?>

<div class="login-box">
    <div class="login-logo">
        <?= Html::encode($this->title) ?>
    </div>

    <div class="card">
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <div class="card-body">
            <?= $form->field($model, 'email', [
                'inputTemplate' => '<div class="input-group mb-3">{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div></div>'
            ]) ?>

            <?= $form->field($model, 'password', [
                'inputTemplate' => '<div class="input-group mb-3">{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div></div>'
            ])->passwordInput() ?>

            <div class="form-check form-check-inline">
                <?= $form->field($model, 'rememberMe')->checkbox(['class' => 'custom-control-input']) ?>
            </div>

            <?= Html::submitButton(Yii::t('backend', 'Button.Login'), [
                'class' => 'btn btn-block btn-primary',
                'name' => 'login-button'
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>