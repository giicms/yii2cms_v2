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
class Video extends \yii\db\ActiveRecord {

    const PUBLISH_ACTIVE = 'publish';
    const PUBLISH_NOACTIVE = 'private';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'videos';
    }

    public function __construct() {
        
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['title'], 'required', 'message' => '{attribute} không được rỗng'],
            [['image', 'keywords', 'description'], 'string'],
            [['title', 'slug'], 'string', 'max' => 255],
            [['tags', 'url','author_url','author_name','video_id'], 'default', 'value' => ''],
            [['category_id'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => Product::PUBLISH_ACTIVE],
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
            'created_at' => 'Ngày tạo',
            'status' => 'Trạng thái',
            'user_id' => 'Người đăng',
            'url_iframe' => 'Url'
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

    public function getCount() {
        return VideoView::find()->where(['video_id' => $this->id])->sum('hit');
    }

    public function getReview() {
        $review = Review::find()->where(['user_id' => \Yii::$app->user->id, 'product_id' => $this->id])->one();
        return $review;
    }

}
