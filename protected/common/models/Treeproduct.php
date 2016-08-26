<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\Product;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $content
 */
class Treeproduct extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tree_products';
    }

    public function getView() {
        return Product::find()->where(['id' => $this->product])->one();
    }

}
