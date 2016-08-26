<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\components\widgets;

use yii\base\Widget;
use common\models\VideoView;
use yii\db\Query;

class ViewWidget extends Widget {

    public $id;

    public function init() {
        
    }

    public function run() {
        $time_now = time();    // lưu thời gian hiện tại
        $time_out = 900; // khoảng thời gian chờ để tính một kết nối mới (tính bằng ms)
        $ip_address = $_SERVER['REMOTE_ADDR'];    // lưu lại IP của kết nối

        $time = $time_now - $time_out;
        $model = VideoView::find()->where(['ip_address' => $ip_address, 'video_id' => $this->id])->one();
        if (!empty($model)) {
            if ($model->last_visit <= $time) {
                $model->last_visit = $time_now;
                $model->hit = $model->hit + 1;
                $model->save();
            }
        } else {
            $counter = new VideoView();
            $counter->ip_address = $ip_address;
            $counter->last_visit = $time_now;
            $counter->video_id = $this->id;
            $counter->hit = 1;
            $counter->save();
        }
    }

}
