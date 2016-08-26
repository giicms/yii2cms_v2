<?php

namespace common\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ManagerProduct as ManagerProductModel;

/**
 * ManagerProduct represents the model behind the search form about `common\models\ManagerProduct`.
 */
class ManagerProduct extends ManagerProductModel {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'user_id', 'created_at'], 'integer'],
            [['status', 'product_id', 'date'], 'safe'],
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
        $query = ManagerProductModel::find();

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
            'product_id' => $this->product_id,
            'number' => $this->number,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
        ]);
        if (!empty($this->created_at)) {
            $time = \Yii::$app->convert->date($this->created_at);
            $t_from = $time - 86400;
            $t_to = $time + 86400;
            $query->andFilterWhere(['>', 'created_at', $t_from]);
            $query->andFilterWhere(['<', 'created_at', $t_to]);
        }
        if (!empty($this->date)) {
            $query->andFilterWhere(['date' => $this->date]);
        }
        $query->andFilterWhere([ 'status' => $this->status]);

        return $dataProvider;
    }

}
