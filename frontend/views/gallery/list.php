<?php

/* @var $list [common\models\domain\Gallery] */

/* @var $pagination yii\data\Pagination */

use common\models\domain\GalleryItem;
use yii\helpers\Html;
use yii\widgets\LinkPager;

$formatter = Yii::$app->formatter;

$this->params['breadcrumbs'][] = Yii::t('frontend', 'Title.Gallery.List');
?>
<main role="main">
    <div class="container">
        <div class="text-center">
            <h1 class="bd-title">
                <?= Yii::t('frontend', 'Title.Gallery.List') ?>
            </h1>

            <?php if ($list && count($list) > 0) { ?>

                <?php
                foreach ($list as $gallery) {
                    $galleryImages = GalleryItem::find()->galleryId($gallery->id)->orderByOrder()->all();

                    if (count($galleryImages) > 0) {
                        $galleryImage = $galleryImages[0];
                        ?>

                        <div class="gallery-item col-lg-4 col-md-4 col-sm-4 col-xs-6">
                            <p>
                                <?= $gallery->title ?>
                            </p>

                            <p>
                                <?= $formatter->asDatetime($gallery->created_at) ?>
                            </p>

                            <?= Html::a(Html::img($galleryImage->getUrl(true), ['class' => 'img-fluid']), $gallery->getUrl(true)) ?>
                        </div>

                        <?php
                    }
                }
                ?>

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
                    <?= Yii::t('frontend', 'Error.Gallery.ListEmpty') ?>
                </p>

            <?php } ?>
        </div>
    </div>
</main>