<?php

/* @var $gallery common\models\domain\Gallery */

/* @var $galleryImageList [common\models\domain\GalleryItem] */

/* @var $pagination yii\data\Pagination */

use frontend\assets\Lightbox2Asset;
use yii\helpers\Html;
use yii\widgets\LinkPager;

Lightbox2Asset::register($this);

$formatter = Yii::$app->formatter;

$this->params['breadcrumbs'][] = Yii::t('frontend', 'Title.Gallery.List');
$this->params['breadcrumbs'][] = $gallery->title;
?>

<main role="main">
    <div class="container">
        <div class="text-center">
            <h1 class="bd-title">
                <?= $gallery->title ?>
            </h1>

            <p>
                <?= $formatter->asDatetime($gallery->created_at) ?>
            </p>

            <?php if ($galleryImageList && count($galleryImageList) > 0) { ?>
                <?php foreach ($galleryImageList as $galleryImage) { ?>
                    <div class="gallery-item col-lg-4 col-md-4 col-sm-4 col-xs-6">
                        <?= Html::a(Html::img($galleryImage->getUrl(true), ['class' => 'img-fluid']), $galleryImage->getUrl(true), ['data-lightbox' => 'gallery']) ?>
                    </div>
                <?php } ?>

                <div class="clearfix"></div>

                <?php
                try {
                    echo(LinkPager::widget([
                        'pagination' => $pagination,
                    ]));
                } catch (Exception $e) {
                    // ignore
                }
                ?>
            <?php } else { ?>
                <p>
                    <?= Yii::t('frontend', 'Error.Gallery.ImageList.Empty') ?>
                </p>
            <?php } ?>

            <br>

            <p>
                <?= Html::a(Yii::t('frontend', 'Button.Back'), ['/gallery/list'], ['class' => 'btn btn-primary']) ?>
            </p>
        </div>
    </div>
</main>