<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Html;

$areaTitle = Yii::t('backend', 'Settings.Area.Title');

$this->title = $areaTitle;
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginContent('@backend/views/shared/module/moduleContainer.php'); ?>

    <div class="card-body">

        <div class="settings-update-permissions-container">

            <h3><?= Yii::t('backend', 'Settings.Area.UpdatePermissions.Title') ?></h3>

            <p><?= Yii::t('backend', 'Settings.Area.UpdatePermissions.Message') ?></p>

            <?= Html::a(Yii::t('backend', 'Settings.Area.UpdatePermissions.Button', ['modelClass' => $areaTitle]), ['settings/update-permissions'], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('backend', 'Message.Confirm'),
                    'method' => 'post',
                ],
            ]) ?>

        </div>

        <hr>

        <div class="settings-clear-cache-container">

            <h3><?= Yii::t('backend', 'Settings.Area.ClearCache.Title') ?></h3>

            <p><?= Yii::t('backend', 'Settings.Area.ClearCache.Message') ?></p>

            <?= Html::a(Yii::t('backend', 'Settings.Area.ClearCache.Button', ['modelClass' => $areaTitle]), ['settings/clear-cache'], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('backend', 'Message.Confirm'),
                    'method' => 'post',
                ],
            ]) ?>

        </div>

        <hr>

        <div class="settings-clear-log-container">

            <h3><?= Yii::t('backend', 'Settings.Area.ClearLog.Title') ?></h3>

            <p><?= Yii::t('backend', 'Settings.Area.ClearLog.Message') ?></p>

            <?= Html::a(Yii::t('backend', 'Settings.Area.ClearLog.Button', ['modelClass' => $areaTitle]), ['settings/clear-log'], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('backend', 'Message.Confirm'),
                    'method' => 'post',
                ],
            ]) ?>

        </div>

    </div>

<?php $this->endContent(); ?>