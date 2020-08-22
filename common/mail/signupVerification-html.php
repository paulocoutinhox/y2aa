<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $customer common\models\domain\Customer */

$verificationLink = (Yii::$app->params['absoluteURL'] . '/customer/signup-verification?token=' . $customer->verification_token);
?>
<div class="signup-verification">
    <?php
    echo Yii::t('common', 'Mail.SignUpVerification.Body.Html', [
        'name' => Html::encode($customer->getPublicIdentity()),
        'link' => Html::a(Html::encode($verificationLink), $verificationLink, ['target' => '_blank']),
    ]);
    ?>
</div>
