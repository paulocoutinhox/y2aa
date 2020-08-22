<?php

use common\models\domain\Content;

/* @var $this yii\web\View */
/* @var $content Content */

$this->title = $content->title;
$this->params['breadcrumbs'][] = $this->title;

?>

<main role="main">
    <div class="container">
        <h1 class="bd-title">
            <?= $content->title ?>
        </h1>

        <p class="lead">
            <?= $content->content ?>
        </p>
    </div>
</main>