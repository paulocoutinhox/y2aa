<?php

namespace common\models\search;

use common\models\domain\Permission;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PermissionSearch represents the model behind the search form about `common\models\domain\Permission`
 */
class PermissionSearch extends Permission
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['description', 'action', 'action_group', 'status'], 'safe'],
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
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Permission::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'action', $this->action])
            ->andFilterWhere(['like', 'action_group', $this->action_group]);

        return $dataProvider;
    }

}
