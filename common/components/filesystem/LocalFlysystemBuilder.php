<?php

namespace common\components\filesystem;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use trntv\filekit\filesystem\FilesystemBuilderInterface;
use Yii;

/**
 * Class LocalFlysystemBuilder
 * @package common\components\filesystem
 */
class LocalFlysystemBuilder implements FilesystemBuilderInterface
{

    public $path;

    public function build()
    {
        $adapter = new Local(Yii::getAlias($this->path));
        return new Filesystem($adapter);
    }

}
