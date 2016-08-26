<?php

namespace backend\controllers;

use Yii;
use common\models\Video;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BackendController;

/**
 * PostController implements the CRUD actions for Post model.
 */
class GetlinkController extends BackendController {

    public function actionIndex() {
        $model = $this->info('eMSTp7Iz7Ns');
        foreach ($model['data'] as $value) {
            parse_str($value, $item);
            echo '<a href="' . $item['url'] . '?title=' . $model['title'] . '">' . $item['type'] . '</a><br>';
        }
        exit;
    }

    private function info($id) {
        $data = parse_str(file_get_contents("http://youtube.com/get_video_info?video_id=" . $id), $info); //decode the data
        $arr = explode(',', $info['url_encoded_fmt_stream_map']);
        $getlink = "https://www.youtube.com/watch?v=" . $id;
        $url = "http://www.youtube.com/oembed?url=" . $getlink . "&format=json";
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $return = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($return, true);

        return ['data' => $arr, 'title' => $result['title']];
    }

}
