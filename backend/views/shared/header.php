<?php
/**
 * @var $this yii\web\View
 */

use yii\helpers\Html;

?>

<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
            <i class="fas fa-bars"></i>
        </a>
    </li>
</ul>

<ul class="navbar-nav ml-auto">
    <!-- User account -->
    <li class="nav-item dropdown">
        <a href="#" class="nav-link" data-toggle="dropdown" aria-expanded="true">
            <i class="fa fa-user-alt mr-2"></i>
            <span>
                <?= Yii::$app->user->identity->name ?>
                <i class="right fas fa-angle-down ml-2"></i>
            </span>
        </a>

        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right text-center p-3"
             style="left: inherit; right: 0;">
            <img src="<?= Yii::$app->user->getIdentity()->getAvatar(Yii::getAlias('@web/images/profile-default.png')) ?>"
                 class="img-circle mb-3" style="width: 70px; height: 70px;"/>

            <div class="mb-3 font-weight-bolder">
                <?= Yii::$app->user->identity->email ?>
            </div>

            <div class="mb-1 text-xs">
                <?= Yii::t('backend', 'SideBarMenu.UserPanel.MemberSince', Yii::$app->user->identity->created_at) ?>
            </div>

            <div class="mb-3 text-xs">
                <?= Yii::t('backend', 'SideBarMenu.UserPanel.LoggedAt', Yii::$app->user->identity->logged_at) ?>
            </div>

            <div class="mb-2">
                <?php
                if (Yii::$app->user->can('profile.index')) {
                    echo Html::a(Yii::t('backend', 'NavBarMenu.Profile'), ['/profile/index'], ['class' => 'btn btn-block btn-primary btn-sm']);
                }
                ?>
            </div>

            <div>
                <?= Html::a(Yii::t('backend', 'NavBarMenu.Logout'), ['/site/logout'], ['class' => 'btn btn-block btn-danger btn-sm', 'data-method' => 'post']) ?>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <?= Html::a('<i class="fa fa-cogs"></i>', ['/settings/index'], ['class' => 'nav-link']) ?>
    </li>
</ul>