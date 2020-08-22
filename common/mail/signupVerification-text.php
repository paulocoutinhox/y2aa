<?php

/* @var $this yii\web\View */
/* @var $customer common\models\domain\Customer */

$verificationLink = (Yii::$app->params['absoluteURL'] . '/customer/signup-verification?token=' . $customer->verification_token);

echo Yii::t('common', 'Mail.SignUpVerification.Body.Text', [
    'name' => $customer->getPublicIdentity(),
    'link' => $verificationLink,
]);