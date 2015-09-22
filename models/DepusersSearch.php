<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Depusers;

/**
 * DepusersSearch represents the model behind the search form about `app\models\Depusers`.
 */
class DepusersSearch extends Depusers
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dus_id', 'dus_us_id', 'dus_dep_id'], 'integer'],
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
        $query = Depusers::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'dus_id' => $this->dus_id,
            'dus_us_id' => $this->dus_us_id,
            'dus_dep_id' => $this->dus_dep_id,
        ]);

        return $dataProvider;
    }
}
