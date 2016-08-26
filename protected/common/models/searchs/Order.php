<?php

namespace common\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Order as OrderModel;

/**
 * Order represents the model behind the search form about `common\models\Order`.
 */
class Order extends OrderModel {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'customer_phone', 'total', 'created_at', 'updated_at'], 'integer'],
            [['customer_name', 'customer_email', 'customer_address', 'products', 'status'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = OrderModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'customer_phone' => $this->customer_phone,
            'total' => $this->total,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'customer_name', $this->customer_name])
                ->andFilterWhere(['like', 'customer_email', $this->customer_email])
                ->andFilterWhere(['like', 'customer_address', $this->customer_address])
                ->andFilterWhere(['like', 'products', $this->products])
                ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }

}
