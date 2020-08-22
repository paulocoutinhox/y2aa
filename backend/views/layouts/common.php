<?php
/**
 * @var $this View
 * @var $content string
 */

use backend\assets\BackendAsset;
use yii\bootstrap4\Alert;
use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\widgets\Breadcrumbs;

$bundle = BackendAsset::register($this);
?>
<?php $this->beginContent('@backend/views/layouts/base.php'); ?>
<div class="wrapper">

    <!-- Header -->
    <nav class="main-header navbar navbar-expand text-sm navbar-dark navbar-lightblue border-bottom-0">
        <?= $this->render('../shared/header') ?>
    </nav>

    <!-- Left side column - Side menu -->
    <?= $this->render('../shared/sideMenu') ?>

    <!-- Right side column - Content -->
    <div class="content-wrapper">

        <!-- Header content  -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            <?= $this->title ?>
                            <?php if (isset($this->params['subtitle'])): ?>
                                <small><?= $this->params['subtitle'] ?></small>
                            <?php endif; ?>
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <?= Breadcrumbs::widget([
                            'tag' => 'ol',
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                            'options' => ['class' => 'breadcrumb float-sm-right'],
                            'itemTemplate' => "<li class='breadcrumb-item'>{link}</li>\n",
                            'activeItemTemplate' => "<li class='breadcrumb-item active'>{link}</li>\n",
                        ]) ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <?php if (Yii::$app->session->hasFlash('flash')): ?>
                <?= Alert::widget([
                    'body' => ArrayHelper::getValue(Yii::$app->session->getFlash('flash'), 'body'),
                    'options' => ArrayHelper::getValue(Yii::$app->session->getFlash('flash'), 'options'),
                ]) ?>
            <?php endif; ?>
            <?= $content ?>
        </section>

    </div>
</div>

<?php $this->endContent(); ?>
