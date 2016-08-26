<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "options".
 *
 * @property integer $id
 * @property string $key
 * @property string $title
 * @property string $description
 * @property string $images
 */
class Option extends \yii\db\ActiveRecord {

    const PUBLISH_ACTIVE = 'publish';
    const PUBLISH_NOACTIVE = 'private';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'options';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['key', 'title'], 'required'],
            [['description'], 'string'],
            [['key'], 'string', 'max' => 50],
            [['title', 'images'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'title' => 'Title',
            'description' => 'Description',
            'images' => 'Images',
        ];
    }

}
