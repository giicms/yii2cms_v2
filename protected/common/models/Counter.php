<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Counter extends ActiveRecord {

    public static function tableName() {
        return 'counter';
    }

    public function rules() {
        return [
            [['last_visit'], 'safe'],
            [['ip_address'], 'string'],
            [['updated_at', 'hit'], 'integer'],
        ];
    }
}
