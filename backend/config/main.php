<?php

use common\components\formatter\SimpleFormatter;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/permissions.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'name' => 'Y2AA',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'components' => [
        'request' => [
            'baseUrl' => '/admin',
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'class' => 'backend\components\BackendUser',
            'identityClass' => 'common\models\domain\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'loginUrl' => ['site/login'],
            'as afterLogin' => common\behaviors\LoginTimestampBehavior::class
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'y2aa-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false
        ],
        'assetManager' => [
            'appendTimestamp' => true
        ],
        'i18n' => [
            'translations' => [
                'backend*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'forceTranslation' => true,
                    'basePath' => '@backend/messages',
                ],
            ],
        ],
        'formatter' => [
            'class' => SimpleFormatter::class
        ]
    ],
    'modules' => [
        'datecontrol' => [
            'class' => '\kartik\datecontrol\Module',
        ],
    ],
    'defaultRoute' => 'site/login',
    'bootstrap' => [
        'log',
        [
            'class' => 'common\components\system\LanguageSelector',
            'supportedLanguages' => $params['supportedLanguages'],
        ],
        [
            'class' => 'common\components\system\TimeZoneSelector',
        ],
    ],
    'params' => $params,
];
