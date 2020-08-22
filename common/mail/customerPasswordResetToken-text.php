<?php

/* @var $this yii\web\View */
/* @var $customer common\models\domain\Customer */

$resetLink = (Yii::$app->params['absoluteURL'] . '/customer/reset-password?token=' . $customer->password_reset_token);

echo Yii::t('common', 'Mail.CustomerRequestPasswordReset.Body.Text', [
    'name' => $customer->getPublicIdentity(),
    'link' => $resetLink,
]);