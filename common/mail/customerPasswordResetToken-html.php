<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $customer common\models\domain\Customer */

$resetLink = (Yii::$app->params['absoluteURL'] . '/customer/reset-password?token=' . $customer->password_reset_token);
?>
<div class="password-reset">
    <?php
    echo Yii::t('common', 'Mail.CustomerRequestPasswordReset.Body.Html', [
        'name' => Html::encode($customer->getPublicIdentity()),
        'link' => Html::a(Html::encode($resetLink), $resetLink, ['target' => '_blank']),
    ]);
    ?>
</div>
