<?php

namespace common\models\search;

use common\models\domain\Customer;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CustomerSearch represents the model behind the search form about `common\models\domain\Customer`
 */
class CustomerSearch extends Customer
{

    public function rules()
    {
        return [
            [['id'], 'integer'],
            ['email', 'string', 'min' => 1, 'max' => 255],
            ['email', 'email'],
            [['name'], 'string', 'min' => 1, 'max' => 255],
            ['gender', 'in', 'range' => [self::GENDER_MALE, self::GENDER_FEMALE]],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
            [['mobile_phone'], 'string', 'min' => 1, 'max' => 11],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Customer::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'email' => $this->email,
            'gender' => $this->gender,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'mobile_phone', $this->mobile_phone]);

        return $dataProvider;
    }

}