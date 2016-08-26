<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $content
 */
class Post extends \yii\db\ActiveRecord {

    const PUBLISH_ACTIVE = 'publish';
    const PUBLISH_NOACTIVE = 'private';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'posts';
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
            [['tags', 'url'], 'default', 'value' => ''],
            [['parent_id'], 'default', 'value' => 0],
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
            'created_at' => 'Ngày tạo',
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

    public function getParent(&$data = [], $parent = 0) {
        $category = Post::find()->where(['parent_id' => $parent, 'type' => 'page'])->all();
        foreach ($category as $key => $value) {
            $data[$value->id] = $this->getIndent($value->indent) . $value->title;
            unset($category[$key]);
            $this->getParent($data, $value->id);
        }
        return $data;
    }

    public function getIndent($int) {
        if ($int > 0) {
            for ($index = 1; $index <= $int; $index++) {
                $data[] = '—';
            }
            return implode('', $data) . ' ';
        } else
            return '';
    }

}
