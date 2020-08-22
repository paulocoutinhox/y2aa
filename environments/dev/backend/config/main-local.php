<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
            'baseUrl' => '/admin',
        ],
        'userProfileFileStorage' => [
            'class' => '\trntv\filekit\Storage',
            'baseUrl' => '/uploads/user-profile',
            'filesystem' => [
                'class' => 'common\components\filesystem\LocalFlysystemBuilder',
                'path' => '@root/uploads/user-profile'
            ],
        ],
    ],
];

if (!YII_ENV_TEST) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['*'],
        'generators' => [
            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator',
                'templates' => [
                    'backend' => '@backend/gii/templates/crud',
                ],
                'modelClass' => 'common\models\domain\CustomName',
                'searchModelClass' => 'common\models\search\CustomNameSearch',
                'controllerClass' => 'backend\controllers\CustomNameController',
                'viewPath' => '@backend/views/custom-name',
                'baseControllerClass' => 'backend\controllers\CRUDController',
                'template' => 'backend',
                'messageCategory' => 'backend'
            ],
            'model' => [
                'class' => 'yii\gii\generators\model\Generator',
                'templates' => [
                    'backend' => '@backend/gii/templates/model',
                ],
                'template' => 'backend',
                'messageCategory' => 'common',
                'ns' => 'common\models\domain',
                'queryNs' => 'common\models\query',
                'generateQuery' => true,
                'useTablePrefix' => true,
                'useSchemaName' => true,
                'enableI18N' => true,
            ]
        ]
    ];

    $config['modules']['gridview'] = [
        'class' => '\kartik\grid\Module'
    ];
}

return $config;
