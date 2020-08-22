<?php

namespace common\models\search;

use common\models\domain\Content;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ContentSearch represents the model behind the search form about `common\models\domain\Content`
 */
class ContentSearch extends Content
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
        $query = Content::find();
        $query->onlyAllowedLanguage();

        $query->joinWith('language');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'content.id' => $this->id,
            'language_id' => $this->language_id,
            'content.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'content.title', $this->title]);

        return $dataProvider;
    }

}