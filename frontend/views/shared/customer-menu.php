<?php

use common\models\util\WebUtil;
use yii\helpers\Url;

?>

<div class="card">
    <div class="card-body">
        <h4 class="bd-title">
            <?= Yii::t('frontend', 'Title.CustomerMenu') ?>
        </h4>

        <ul class="nav nav-pills nav-fill flex-column customer-menu">
            <li class="nav-item">
                <a class="text-left nav-link <?= (WebUtil::isActionActive(['customer/profile']) ? 'active' : null) ?>"
                   href="<?= Url::to(['/customer/profile']) ?>">
                    <?= Yii::t('frontend', 'CustomerMenu.Profile') ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="text-left nav-link <?= (WebUtil::isActionActive(['customer/update']) ? 'active' : null) ?>"
                   href="<?= Url::to(['/customer/update']) ?>">
                    <?= Yii::t('frontend', 'CustomerMenu.UpdateProfile') ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="text-left nav-link <?= (WebUtil::isActionActive(['customer/update-password']) ? 'active' : null) ?>"
                   href="<?= Url::to(['/customer/update-password']) ?>">
                    <?= Yii::t('frontend', 'CustomerMenu.UpdatePassword') ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="text-left nav-link <?= (WebUtil::isActionActive(['customer/update-image']) ? 'active' : null) ?>"
                   href="<?= Url::to(['/customer/update-image']) ?>">
                    <?= Yii::t('frontend', 'CustomerMenu.UpdateImage') ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="text-left nav-link <?= (WebUtil::isActionActive(['customer/logout']) ? 'active' : null) ?>"
                   href="<?= Url::to(['/customer/logout']) ?>">
                    <?= Yii::t('frontend', 'CustomerMenu.Logout') ?>
                </a>
            </li>
        </ul>
    </div>
</div>