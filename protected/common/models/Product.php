<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\Review;
/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $content
 */
class Product extends \yii\db\ActiveRecord {

    const PUBLISH_ACTIVE = 'publish';
    const PUBLISH_NOACTIVE = 'private';
    const FEATURED_OPEN = 1;
    const FEATURED_CLOSE = 0;
    const SLIDE_OPEN = 1;
    const SLIDE_CLOSE = 0;

    public $category_id;
    public $price_from;
    public $price_to;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'products';
    }

    public function __construct() {
        
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['title'], 'required', 'message' => '{attribute} không được rỗng'],
            [['content', 'images', 'keywords', 'description'], 'string'],
            [['title', 'slug'], 'string', 'max' => 255],
            [['tags', 'price', 'price_sale', 'size', 'color'], 'default', 'value' => ''],
            [['price', 'price_sale', 'number'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => Product::PUBLISH_NOACTIVE],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'category_id' => 'Danh mục',
            'title' => 'Tiêu đề',
            'keywords' => 'Meta Keywords',
            'description' => 'Meta Description',
            'content' => 'Nội dung',
            'image' => 'Hình ảnh',
            'price' => 'Giá',
            'slide' => 'Hiển thị trên slide',
            'created_at' => 'Ngày đăng',
            'status' => 'Trạng thái',
            'user_id' => 'Người đăng'
        ];
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ]);
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getTree() {
        $model = Treeproduct::find()->where(['product' => $this->id])->all();
        $data = [];
        if (!empty($model)) {
            foreach ($model as $value) {
                $data[] = $value->tree;
            }
        }
        return Tree::find()->where(['IN', 'id', $data])->all();
    }

    public function getPostStatus() {
        return [
            self::STATUS_PUBLISH => 'Mọi người',
            self::STATUS_PRIVATE => 'Riêng tư',
        ];
    }

//    public function getCategory() {
//        $post = Post::findOne($this->id);
//        $data = [];
//        foreach (explode(',', $post->category_id) as $value) {
//            $category = Category::findOne($value);
//            if (!empty($category))
//                $data[] = ['id' => $category->id, 'parent_id' => $category->parent_id, 'title' => $category->title, 'indent' => $this->getIndent($category->indent)];
//        }
//        return $data;
//    }

    public function getIndent($int) {
        if ($int > 0) {
            for ($index = 1; $index <= $int; $index++) {
                $data[] = '—';
            }
            return implode('', $data) . ' ';
        } else
            return '';
    }

    public function getCountrating() {
        $count_5 = Review::find()->where(['product_id' => $this->id, 'star' => '5'])->count();
        $count_4 = Review::find()->where(['product_id' => $this->id, 'star' => '4'])->count();
        $count_3 = Review::find()->where(['product_id' => $this->id, 'star' => '3'])->count();
        $count_2 = Review::find()->where(['product_id' => $this->id, 'star' => '2'])->count();
        $count_1 = Review::find()->where(['product_id' => $this->id, 'star' => '1'])->count();
        if (($count_1 + $count_2 + $count_4 + $count_3 + $count_5) > 0) {
            $total = ($count_1 + $count_2 + $count_4 + $count_3 + $count_5) / (($count_5 * 5) + ($count_4 * 4) + ($count_3 * 3) + ($count_2 * 2) + ($count_1 * 1));
            return round($total, 1);
        } else
            return 0;
    }

}
