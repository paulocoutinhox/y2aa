<?php

namespace backend\assets;

use yii\web\AssetBundle;

class AdminLteAsset extends AssetBundle
{

    public $sourcePath = '@bower/admin-lte/dist';

    public $js = [
        'js/adminlte.js',
    ];

    public $css = [
        'css/adminlte.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
        'backend\assets\FontAwesomeAsset',
    ];

}
