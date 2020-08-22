<?php

/* @var $this View */

use common\models\domain\Language;
use common\models\util\CacheUtil;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Url;
use yii\web\View;

NavBar::begin([
    'brandLabel' => Yii::t('frontend', 'Title.App'),
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar navbar-expand-lg navbar-dark bg-primary',
    ],
]);

$menuItems = [
    ['label' => Yii::t('frontend', 'App.Menu.Home'), 'url' => ['/site/index']]
];

// links
$linksSubItems = [
    ['label' => Yii::t('frontend', 'App.Menu.AboutUs'), 'url' => ['/content/index', 'tag' => 'about-us', 'language' => 'auto']],
    ['label' => Yii::t('frontend', 'App.Menu.TermsOfUse'), 'url' => ['/content/index', 'tag' => 'terms-of-use', 'language' => 'auto']],
    ['label' => Yii::t('frontend', 'App.Menu.PrivacyPolicy'), 'url' => ['/content/index', 'tag' => 'privacy-policy', 'language' => 'auto']],
    ['label' => Yii::t('frontend', 'App.Menu.GalleryList'), 'url' => ['/gallery/list']],
    ['label' => Yii::t('frontend', 'App.Menu.Download'), 'url' => ['/download/index']],
    ['label' => Yii::t('frontend', 'App.Menu.ResendVerificationEmail'), 'url' => ['/customer/resend-verification-email']],
    ['label' => Yii::t('frontend', 'App.Menu.Contact'), 'url' => ['/contact/index']],
];

$menuItems[] = [
    'label' => Yii::t('frontend', 'App.Menu.Links'),
    'url' => '#',
    'items' => $linksSubItems,
];

// languages
$languagesSubItems = [];

$languages = Language::find()
    ->cache(CacheUtil::FRONTEND_CACHE_LANGUAGE)
    ->orderBy('name')
    ->all();

foreach ($languages as $language) {
    $languagesSubItems[] = [
        'label' => $language->native_name,
        'url' => 'javascript: Language.change(' . $language->id . ')',
        'icon' => Url::to('@web/images/flags/' . $language->code_iso_language . '.png'),
    ];
}

$menuItems[] = [
    'label' => Yii::t('frontend', 'App.Menu.Language'),
    'url' => '#',
    'items' => $languagesSubItems,
    'encodeLabels' => false,
];

// other menus
if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => Yii::t('frontend', 'App.Menu.SignUp'), 'url' => ['/customer/signup']];
    $menuItems[] = ['label' => Yii::t('frontend', 'App.Menu.Login'), 'url' => ['/customer/login']];
} else {
    $menuItems[] = ['label' => Yii::t('frontend', 'App.Menu.MyAccount'), 'url' => ['/customer/profile']];
    $menuItems[] = ['label' => Yii::t('frontend', 'App.Menu.Logout', ['name' => Yii::$app->user->identity->getPublicIdentity()]), 'url' => ['/customer/logout']];
}

try {
    echo(Nav::widget([
        'options' => ['class' => 'navbar-nav ml-auto'],
        'items' => $menuItems,
    ]));
} catch (Exception $e) {
    // ignore
}

NavBar::end();

echo($this->render('/shared/common.php'));