<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $customer common\models\domain\Customer */
?>
<div class="welcome">
    <?php
    echo Yii::t('common', 'Mail.Welcome.Body.Html', [
        'customer.id' => Html::encode(($customer ? $customer->getId() : null)),
        'customer.name' => Html::encode(($customer ? $customer->name : null)),
        'customer.email' => Html::encode(($customer ? $customer->email : null)),
    ]);
    ?>
</div>
