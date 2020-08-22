<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $customer common\models\domain\Customer */

echo Yii::t('common', 'Mail.Welcome.Body.Text', [
    'customer.id' => Html::encode(($customer ? $customer->getId() : null)),
    'customer.name' => Html::encode(($customer ? $customer->name : null)),
    'customer.email' => Html::encode(($customer ? $customer->email : null)),
]);
