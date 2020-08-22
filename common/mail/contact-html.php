<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $customer common\models\domain\Customer */
/* @var $name string */
/* @var $email string */
/* @var $message string */
?>
<div class="contact">
    <?php
    echo Yii::t('common', 'Mail.Contact.Body.Html', [
        'customer.id' => Html::encode(($customer ? $customer->getId() : null)),
        'customer.name' => Html::encode(($customer ? $customer->name : null)),
        'customer.email' => Html::encode(($customer ? $customer->email : null)),
        'form.name' => Html::encode($name),
        'form.email' => Html::encode($email),
        'form.message' => nl2br(Html::encode($message)),
    ]);
    ?>
</div>
