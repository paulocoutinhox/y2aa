<?php

namespace backend\assets;

use yii\web\AssetBundle;

class JsCookieAsset extends AssetBundle
{

    public $sourcePath = '@bower/js-cookie/src';

    public $js = [
        'js.cookie.js'
    ];

}
