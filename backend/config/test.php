<?php

return [
    'id' => 'app-backend-tests',
    'components' => [
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
            'appendTimestamp' => true,
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
    ],
];
