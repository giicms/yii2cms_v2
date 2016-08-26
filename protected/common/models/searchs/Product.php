<?php

namespace common\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Product as ProductModel;
use common\models\Treeproduct;

/**
 * Option represents the model behind the search form about `common\models\Option`.
 */
class Product extends ProductModel {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['category_id', 'created_at', 'price', 'title', 'status'], 'safe'],
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
        $query = ProductModel::find();

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
        $category = Treeproduct::findAll(['tree' => $this->category_id]);
        if (!empty($category)) {
            foreach ($category as $value) {
                $ids[] = $value->product;
            }
        } else
            $ids = [];
        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['in', 'id', $ids]);
        if (!empty($this->price)) {
            $price = explode(',', $this->price);
            $from = $price[0];
            $to = $price[1];
            $query->andFilterWhere(['>', 'price', $from]);
            $query->andFilterWhere(['<', 'price', $to]);
        }
        if (!empty($this->created_at)) {
            $time = \Yii::$app->convert->date($this->created_at);
            $t_from = $time - 86400;
            $t_to = $time + 86400;
            $query->andFilterWhere(['>', 'created_at', $t_from]);
            $query->andFilterWhere(['<', 'created_at', $t_to]);
        }

        $query->andFilterWhere(['status' => $this->status]);

        return $dataProvider;
    }

}
