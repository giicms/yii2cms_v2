<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class VideoView extends ActiveRecord {

    public static function tableName() {
        return 'video_views';
    }

    public function rules() {
        return [
            [['last_visit'], 'safe'],
            [['ip_address'], 'string'],
             [['last_visit', 'hit','video_id'], 'integer'],
        ];
    }


}
