<?php

namespace frontend\controllers;

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
class GetlinkController extends Controller {

    public function actionIndex() {
        $model = new \common\models\GetLink();
        $info = '';
        if ($model->load(Yii::$app->request->post())) {
            $info = $this->info($model->url);
        }
        return $this->render('index', [
                    'model' => $model,
                    'info' => $info
        ]);
    }

    public function actionView($v) {
        $info = $this->info('https://www.youtube.com/watch?v=' . $v);
        return $this->render('view', [
                    'info' => $info
        ]);
    }

    private function info($link) {
        parse_str(parse_url($link, PHP_URL_QUERY), $id);
        $url = "http://www.youtube.com/oembed?url=" . $link . "&format=json";
        if (!empty($url)) {
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $return = curl_exec($curl);
            curl_close($curl);
            $result = json_decode($return, true);
            $data = parse_str(file_get_contents("http://youtube.com/get_video_info?video_id=" . $id['v']), $info); //decode the data
            $arr = explode(',', $info['url_encoded_fmt_stream_map']);
            return ['data' => $arr, 'title' => $result['title']];
        }
    }

}
