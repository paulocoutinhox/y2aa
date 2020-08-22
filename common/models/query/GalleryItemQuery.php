<?php

namespace common\models\query;

use common\models\domain\GalleryItem;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\domain\GalleryItem]].
 *
 * @see \common\models\domain\GalleryItem
 */
class GalleryItemQuery extends ActiveQuery
{

    public function orderByOrder()
    {
        return $this->addOrderBy('[[order]] ASC');
    }

    public function galleryId($galleryId)
    {
        return $this->andWhere('[[gallery_id]] = :gallery_id', ['gallery_id' => $galleryId]);
    }

    /**
     * @inheritdoc
     * @return GalleryItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return GalleryItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
