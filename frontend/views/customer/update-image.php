<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */

/* @var $model Customer */

use common\models\domain\Customer;
use trntv\filekit\widget\Upload;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('frontend', 'Title.Customer.UpdateImage');
$this->params['breadcrumbs'][] = $this->title;
?>

<main role="main">
    <div class="container">
        <h1 class="bd-title">
            <?= Html::encode($this->title) ?>
        </h1>

        <div class="row">
            <div class="col-12 col-lg-3">
                <?= $this->render('/shared/customer-menu.php') ?>
            </div>
            <div class="col-12 col-lg-9 mt-4 mt-lg-0">
                <div class="card">
                    <div class="card-header">
                        <strong>
                            <?= Yii::t('frontend', 'Title.Customer.UpdateImage') ?>
                        </strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-lg-12 col-xl-12 text-center">
                                <?php $form = ActiveForm::begin(); ?>

                                <?= $form->field($model, 'avatar')->label(false)->widget(Upload::class, [
                                    'url' => ['avatar-upload'],
                                ]) ?>

                                <div class="form-group">
                                    <?= Html::submitButton(Yii::t('frontend', 'Button.Customer.UpdateImage.Form.Confirm'), ['class' => 'btn btn-primary']) ?>
                                </div>

                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
