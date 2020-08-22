<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle
 */
class BackendAsset extends AssetBundle
{

    public $basePath = '@webroot';

    public $baseUrl = '@web';

    public $css = [
        'css/app.css',
    ];

    public $js = [
        'js/app.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'backend\assets\JsCookieAsset',
        'backend\assets\AdminLteAsset',
        'backend\assets\BootboxAsset',
    ];

}
