<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */

/* @var $model LoginForm */

use frontend\models\form\LoginForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('frontend', 'Title.Customer.Profile');
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
                    <div class="card-body">
                        <div class="text-center">
                            <p>
                                <a href="<?= Url::to(['/customer/update-image']) ?>">
                                    <img src="<?= Yii::$app->user->identity->getAvatar(Yii::$app->request->baseUrl . '/images/profile-default-mini.png') ?>"
                                         alt="" style="width: 100px; height: 100px;" class="rounded-circle">
                                </a>
                            </p>
                            <p>
                                <?= Yii::$app->user->identity->name ?>
                            </p>
                            <p>
                                <?= Yii::$app->user->identity->email ?>
                            </p>
                            <p>
                                <a href="<?= Url::to(['/customer/update']) ?>" class="btn btn-primary btn-sm">
                                    <?= Yii::t('frontend', 'Button.Customer.UpdateProfile') ?>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

                <br>

                <div class="card">
                    <div class="card-header">
                        <strong>
                            <?= Yii::t('frontend', 'Title.Customer.Card') ?>
                        </strong>
                    </div>
                    <div class="card-body">
                        <?= Yii::t('frontend', 'Message.Customer.Card.Empty') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
