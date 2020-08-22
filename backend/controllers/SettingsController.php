<?php

namespace backend\controllers;

use common\models\domain\Log;
use common\models\util\PermissionUtil;
use Yii;
use yii\filters\VerbFilter;

/**
 * SettingsController has internal operations
 */
class SettingsController extends BaseController
{

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get', 'post'],
                    'update-permissions' => ['post'],
                ],
            ],
        ]);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionUpdatePermissions()
    {
        PermissionUtil::updatePermissions();

        Yii::$app->session->setFlash('flash', [
            'options' => ['class' => 'alert-success'],
            'body' => Yii::t('backend', 'Settings.Area.UpdatePermissions.FinishedOK')
        ]);

        return Yii::$app->getResponse()->redirect('index');
    }

    public function actionClearCache()
    {
        Yii::$app->cache->flush();

        Yii::$app->session->setFlash('flash', [
            'options' => ['class' => 'alert-success'],
            'body' => Yii::t('backend', 'Settings.Area.ClearCache.FinishedOK')
        ]);

        return Yii::$app->getResponse()->redirect('index');
    }

    public function actionClearLog()
    {
        Log::deleteAll();

        Yii::$app->session->setFlash('flash', [
            'options' => ['class' => 'alert-success'],
            'body' => Yii::t('backend', 'Settings.Area.ClearLog.FinishedOK')
        ]);

        return Yii::$app->getResponse()->redirect('index');
    }

}
