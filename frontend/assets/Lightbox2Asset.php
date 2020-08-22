<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Lightbox2 asset bundle.
 */
class Lightbox2Asset extends AssetBundle
{
    public $sourcePath = '@bower/lightbox2/dist';
    public $css = [
        'css/lightbox.css',
    ];
    public $js = [
        'js/lightbox.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}