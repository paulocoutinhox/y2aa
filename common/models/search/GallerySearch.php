<?php

namespace common\models\search;

use common\models\domain\Gallery;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * GallerySearch represents the model behind the search form about `common\models\domain\Gallery`
 */
class GallerySearch extends Gallery
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'language_id'], 'integer'],
            [['title', 'tag', 'status'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Gallery::find();
        $query->onlyAllowedLanguage();

        $query->joinWith('language');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'gallery.id' => $this->id,
            'gallery.language_id' => $this->language_id,
            'gallery.status' => $this->status,
            'gallery.tag' => $this->tag,
        ]);

        $query->andFilterWhere(['like', 'gallery.title', $this->title]);

        return $dataProvider;
    }

}
