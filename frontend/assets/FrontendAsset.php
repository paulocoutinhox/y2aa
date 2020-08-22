<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class FrontendAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'vendor/bootstrap4/css/bootstrap.min.css',
        'vendor/bootstrap4-dialog/css/bootstrap-dialog.min.css',
        'css/app.css',
    ];

    public $js = [
        'vendor/bootstrap4/js/bootstrap.bundle.min.js',
        'vendor/bootstrap4-dialog/js/bootstrap-dialog.min.js',
        'js/app.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];

}
