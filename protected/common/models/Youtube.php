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
class Youtube extends \yii\base\Model {

    public $channelId;
    public $total;
    public $option;

    public function __construct() {
        
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['channelId', 'total','option'], 'required', 'message' => '{attribute} không được rỗng'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'channelId' => 'Channel Id or Video Id',
            'total' => 'So luong mau tin',
        ];
    }

    public function getOptions() {
        return [
            'channel' => 'Channel',
            'video' => 'Video'
        ];
    }

}
