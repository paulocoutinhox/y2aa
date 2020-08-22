<?php
$config = [
    'components' => [
        'db' => [
            'class' => '\yii\db\Connection',
            'dsn' => 'mysql:host=mysql;dbname=y2aa',
            'username' => 'root',
            'password' => 'root',
            'tablePrefix' => '',
            'charset' => 'utf8',
            'enableSchemaCache' => YII_ENV_PROD,
            'schemaCacheDuration' => 3600,
            'schemaCache' => 'cache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'mailcatcher',
                'port' => '1025',
            ],
        ],
        'customerProfileFileStorage' => [
            'class' => '\trntv\filekit\Storage',
            'baseUrl' => '@web/uploads/customer-profile',
            'filesystem' => [
                'class' => 'common\components\filesystem\LocalFlysystemBuilder',
                'path' => '@root/uploads/customer-profile'
            ],
        ],
        'galleryFileStorage' => [
            'class' => '\trntv\filekit\Storage',
            'baseUrl' => '/uploads/gallery',
            'filesystem' => [
                'class' => 'common\components\filesystem\LocalFlysystemBuilder',
                'path' => '@root/uploads/gallery'
            ],
        ],
        'jwt' => [
            'class' => 'common\components\jwt\JWT',
            'key' => '@JWT-KEY@',
        ],
        'cache' => [
            'class' => 'yii\caching\DbCache',
            'db' => 'db',
            'cacheTable' => 'cache',
        ],
    ],
];

return $config;
