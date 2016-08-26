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
class VideoFacebook extends \yii\base\Model {

    public $fid;
    public $limit;
    public $category_id;

    public function __construct() {
        
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['fid', 'limit'], 'required', 'message' => '{attribute} không được rỗng'],
            [['category_id'], 'default'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'fid' => 'Facebook Id',
            'category_id' => 'Danh muc'
        ];
    }

}
