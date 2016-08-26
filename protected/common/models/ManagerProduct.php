<?php

namespace common\models;

use Yii;

class ManagerProduct extends \yii\db\ActiveRecord {

    public $name;

    const STATUS_EXPORT = 'export';
    const STATUS_IMPORT = 'import';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'manager_products';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['product_id', 'date'], 'required'],
            [['number'], 'integer'],
            [['status'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'user_id' => 'Author',
            'product_id' => 'Sản phẩm',
            'number' => 'Số lượng',
            'date' => 'Thời thian xuất, nhập',
            'status' => 'Trạng thái',
            'created_at' => 'Ngày đăng',
        ];
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getProduct() {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

}
