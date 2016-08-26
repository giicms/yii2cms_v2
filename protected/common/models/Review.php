<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Blog Category model
 *
 * @property string $name
 * @property string $sectors
 */
class Review extends ActiveRecord {

    public static function tableName() {
        return 'reviews';
    }

    public function rules() {
        return [
            [['content'], 'string'],
            [['star', 'user_id', 'product_id'], 'integer'],
        ];
    }

    public function attributes() {
        return [
            'id',
            'content',
            'user_id',
            'product_id',
            'star',
            'created_at',
            'updated_at'
        ];
    }

    public function behaviors() {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
