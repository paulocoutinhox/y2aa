<?php
return [
    [
        'name' => 'Webmaster',
        'auth_key' => '2G62gPD4AlEcnMxWDhTPNPT40JWjis7H',
        'password_hash' => '$2y$13$j9k93H1RU/jpQVzFpUxH0.Nt0GJ4Qdjaqh8NDl1QlSg2zbFcfcHyC', // webmaster@password
        'password_reset_token' => Yii::$app->security->generateRandomString() . '_' . time(),
        'email' => 'paulo@prsolucoes.com',
        'status' => 'active',
        'root' => 'yes',
        'gender' => 'male',
        'language_id' => 1,
        'timezone' => 'America/Sao_Paulo',
        'created_at' => '1565479063',
        'updated_at' => '1565479063',
    ],
];
