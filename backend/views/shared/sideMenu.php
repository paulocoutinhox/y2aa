<?php
/**
 * @var $this yii\web\View
 */

use backend\widgets\Menu;
use common\models\util\WebUtil;
use yii\helpers\Html;

?>
<aside class="main-sidebar elevation-4 sidebar-dark-lightblue">
    <!-- Brand Logo -->
    <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('/') ?>"
       class="brand-link navbar-lightblue border-bottom-0 text-sm">
        <img class="brand-image img-circle" src="<?= Yii::getAlias('@web/images/sidebar-mini-logo.png') ?>"/>
        <span class="brand-text font-weight-normal">
            <?= Yii::t('backend', 'Title.App') ?>
        </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar navbar-gray-dark">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 mb-4 pb-3 d-flex text-sm">
            <div class="image mt-2">
                <img src="<?= Yii::$app->user->getIdentity()->getAvatar(Yii::getAlias('@web/images/profile-default.png')) ?>"
                     class="img-circle elevation-0" alt="">
            </div>
            <div class="info">
                <?php
                if (Yii::$app->user->can('profile.index')) {
                    echo(Html::a(Yii::$app->user->identity->getPublicIdentity(), ['/profile/index'], ['class' => 'd-block']));
                } else {
                    echo(Html::a('#', ['/profile/index'], ['class' => 'd-block']));
                }
                ?>
                <a class="d-block text-xs">
                    <?= Yii::t('backend', 'SideBarMenu.UserPanel.LoggedAt', Yii::$app->user->identity->created_at) ?>
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">

            <?php
            $menuItems = [];

            //////////////////////////////////////////////////////////////////////
            // MENU - HOME CONTENT
            //////////////////////////////////////////////////////////////////////

            if (Yii::$app->user->can('menu.main')) {
                $subItems = [];
                $isOpen = false;

                if (Yii::$app->user->can('site.index')) {
                    $active = WebUtil::isActionActive(['/site/index']);

                    if ($active) {
                        $isOpen = true;
                    }

                    $subItems[] = [
                        'label' => Yii::t('backend', 'SideBarMenu.Item.Dashboard'),
                        'icon' => 'fa-tachometer-alt',
                        'url' => ['/site/index'],
                        'active' => $active,
                    ];
                }

                if (Yii::$app->user->can('content.index')) {
                    $active = WebUtil::isActionActive(['/content/*']);

                    if ($active) {
                        $isOpen = true;
                    }

                    $subItems[] = [
                        'label' => Yii::t('backend', 'SideBarMenu.Item.Contents'),
                        'icon' => 'fa-file-alt',
                        'url' => ['/content/index'],
                        'active' => $active,
                    ];
                }

                if (Yii::$app->user->can('customer.index')) {
                    $active = WebUtil::isActionActive(['/customer/*', '/customer-address/*']);

                    if ($active) {
                        $isOpen = true;
                    }

                    $subItems[] = [
                        'label' => Yii::t('backend', 'SideBarMenu.Item.Customers'),
                        'icon' => 'fa-user-friends',
                        'url' => ['/customer/index'],
                        'active' => $active,
                    ];
                }

                if (Yii::$app->user->can('gallery.index')) {
                    $active = WebUtil::isActionActive(['/gallery/*']);

                    if ($active) {
                        $isOpen = true;
                    }

                    $subItems[] = [
                        'label' => Yii::t('backend', 'SideBarMenu.Item.Galleries'),
                        'icon' => 'fa-images',
                        'url' => ['/gallery/index'],
                        'active' => $active,
                    ];
                }

                $menuItems[] = [
                    'label' => Yii::t('backend', 'SideBarMenu.Title.Main'),
                    'url' => '#',
                    'icon' => 'fa-home',
                    'options' => ['class' => 'nav-item has-treeview ' . ($isOpen ? 'menu-open' : '')],
                    'items' => $subItems,
                ];
            }

            //////////////////////////////////////////////////////////////////////
            // MENU - REPORT
            //////////////////////////////////////////////////////////////////////

            if (Yii::$app->user->can('menu.report')) {
                $subItems = [];
                $isOpen = false;

                if (Yii::$app->user->can('reports.customer-report.index')) {
                    $active = WebUtil::isActionActive(['/reports/customer-report/index']);

                    if ($active) {
                        $isOpen = true;
                    }

                    $subItems[] = [
                        'label' => Yii::t('backend', 'SideBarMenu.Item.Report.CustomerReport'),
                        'icon' => 'fa-user-friends',
                        'url' => ['/reports/customer-report/index'],
                        'active' => $active,
                    ];
                }

                if (Yii::$app->user->can('reports.user-report.index')) {
                    $active = WebUtil::isActionActive(['/reports/user-report/index']);

                    if ($active) {
                        $isOpen = true;
                    }

                    $subItems[] = [
                        'label' => Yii::t('backend', 'SideBarMenu.Item.Report.UserReport'),
                        'icon' => 'fa-user',
                        'url' => ['/reports/user-report/index'],
                        'active' => $active,
                    ];
                }

                $menuItems[] = [
                    'label' => Yii::t('backend', 'SideBarMenu.Title.Report'),
                    'url' => '#',
                    'icon' => 'fa-chart-pie',
                    'options' => ['class' => 'nav-item has-treeview ' . ($isOpen ? 'menu-open' : '')],
                    'items' => $subItems,
                ];
            }

            //////////////////////////////////////////////////////////////////////
            // MENU - SYSTEM
            //////////////////////////////////////////////////////////////////////

            if (Yii::$app->user->can('menu.system')) {
                $subItems = [];
                $isOpen = false;

                if (Yii::$app->user->can('log.index')) {
                    $active = WebUtil::isActionActive(['/log/*']);

                    if ($active) {
                        $isOpen = true;
                    }

                    $subItems[] = [
                        'label' => Yii::t('backend', 'SideBarMenu.Item.Logs'),
                        'icon' => 'fa-history',
                        'url' => ['/log/index'],
                        'active' => $active,
                    ];
                }

                if (Yii::$app->user->can('user.index')) {
                    $active = WebUtil::isActionActive(['/user/*']);

                    if ($active) {
                        $isOpen = true;
                    }

                    $subItems[] = [
                        'label' => Yii::t('backend', 'SideBarMenu.Item.Users'),
                        'icon' => 'fa-user',
                        'url' => ['/user/index'],
                        'active' => WebUtil::isActionActive(['/user/*']),
                    ];
                }

                if (Yii::$app->user->can('group.index')) {
                    $active = WebUtil::isActionActive(['/group/*']);

                    if ($active) {
                        $isOpen = true;
                    }

                    $subItems[] = [
                        'label' => Yii::t('backend', 'SideBarMenu.Item.Groups'),
                        'icon' => 'fa-users',
                        'url' => ['/group/index'],
                        'active' => $active,
                    ];
                }

                if (Yii::$app->user->can('permission.index')) {
                    $active = WebUtil::isActionActive(['/permission/*']);

                    if ($active) {
                        $isOpen = true;
                    }

                    $subItems[] = [
                        'label' => Yii::t('backend', 'SideBarMenu.Item.Permissions'),
                        'icon' => 'fa-tags',
                        'url' => ['/permission/index'],
                        'active' => $active,
                    ];
                }

                if (Yii::$app->user->can('preferences.index')) {
                    $active = WebUtil::isActionActive(['/preference/*']);

                    if ($active) {
                        $isOpen = true;
                    }

                    $subItems[] = [
                        'label' => Yii::t('backend', 'SideBarMenu.Item.Preferences'),
                        'icon' => 'fa-wrench',
                        'url' => ['/preference/index'],
                        'active' => $active,
                    ];
                }

                if (Yii::$app->user->can('profile.index')) {
                    $active = WebUtil::isActionActive(['/profile/index']);

                    if ($active) {
                        $isOpen = true;
                    }

                    $subItems[] = [
                        'label' => Yii::t('backend', 'SideBarMenu.Item.Profile'),
                        'icon' => 'fa-id-badge',
                        'url' => ['/profile/index'],
                        'active' => $active,
                    ];
                }

                if (Yii::$app->user->can('settings.index')) {
                    $active = WebUtil::isActionActive(['/settings/index']);

                    if ($active) {
                        $isOpen = true;
                    }

                    $subItems[] = [
                        'label' => Yii::t('backend', 'SideBarMenu.Item.Settings'),
                        'icon' => 'fa-cog',
                        'url' => ['/settings/index'],
                        'active' => $active,
                    ];
                }

                $subItems[] = [
                    'label' => Yii::t('backend', 'SideBarMenu.Item.Logout'),
                    'icon' => 'fa-sign-out-alt',
                    'url' => ['/site/logout']
                ];

                $menuItems[] = [
                    'label' => Yii::t('backend', 'SideBarMenu.Title.System'),
                    'url' => '#',
                    'icon' => 'fa-cog',
                    'options' => ['class' => 'nav-item has-treeview ' . ($isOpen ? 'menu-open' : '')],
                    'items' => $subItems,
                ];
            }

            //////////////////////////////////////////////////////////////////////
            // CREATE MENU
            //////////////////////////////////////////////////////////////////////

            echo Menu::widget([
                'options' => ['class' => 'nav nav-pills nav-sidebar flex-column nav-legacy text-sm nav-child-indent navbar-gray-dark', 'data-widget' => 'treeview', 'role' => 'menu', 'data-accordion' => 'false'],
                'linkTemplate' => '<a class="nav-link my-link-template {class}" href="{url}"><i class="nav-icon fa {icon}"></i><p>{label}{right-icon}</p>{badge}</a>',
                'submenuTemplate' => "\n<ul class=\"nav nav-treeview\">\n{items}\n</ul>\n",
                'activateParents' => true,
                'activateItems' => true,
                'items' => $menuItems,
                'itemOptions' => ['class' => 'nav-item'],
            ]);
            ?>
        </nav>
    </div>
</aside>