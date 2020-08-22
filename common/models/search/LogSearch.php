<?php

namespace common\models\search;

use common\models\domain\Log;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * LogSearch represents the model behind the search form about `common\models\domain\Log`
 */
class LogSearch extends Log
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'level'], 'integer'],
            [['source'], 'safe'],
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
        $query = Log::find();

        $query->joinWith('customer');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'log.id' => $this->id,
            'customer_id' => $this->customer_id,
            'log.level' => $this->level,
            'log.source' => $this->source,
        ]);

        return $dataProvider;
    }

}
