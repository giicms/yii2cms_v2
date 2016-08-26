<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Video;

/**
 * Site controller
 */
class FacebookController extends Controller {

    public function actionIndex() {
        $model = new \common\models\VideoFacebook();
        $videos = [];
        if ($model->load(Yii::$app->request->post())) {
            $link = "https://graph.facebook.com/" . $model->fid . "/videos?access_token=" . $this->getToken();
            $response = $this->curl_get_contents($link);
            var_dump($response); exit;
            $response = json_decode($response, true);
            for ($i = 0; $i < $model->limit; $i++) {
                $v = $this->getVideo($response['data'][$i]['id']);
                $exit = Video::find()->where(['type' => 'facebook', 'video_id' => $response['data'][$i]['id']])->one();
                if (!$exit) {
                    $video = new Video();
                    $video->title = $v['description'];
                    $video->slug = \Yii::$app->convert->string($v['description']);
                    $video->file = $v['source'];
                    $video->image = $v['picture'];
                    $video->url = $v['embed_html'];
                    $video->type = 'facebook';
                    $video->video_id = $v['id'];
                    $video->category_id = $_POST['category_id'];
                    $video->status = Video::PUBLISH_NOACTIVE;
                    $video->save();
                }
                $videos[] = $v;
            }
        }
        return $this->render('index', [
                    'model' => $model,
                    'videos' => $videos
        ]);
    }

    protected function getVideo($id) {
        $response = file_get_contents('https://graph.facebook.com/' . $id);
        $response = json_decode($response, true);
        return $response;
    }

    protected function curl_get_contents($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    protected function getToken() {
        return '502205273320053|502205273320053|y2nFHy4ZvcAZ2pukPCtTRS_LSQM';
    }

}
