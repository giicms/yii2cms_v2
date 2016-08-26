<?php

namespace backend\controllers;

use Yii;
use backend\controllers\BackendController;

/**
 * Site controller
 */
class FacebookController extends BackendController {

    public function actionIndex() {
        $model = new \common\models\VideoFacebook();
              $link = "https://graph.facebook.com/funbabyvideos/videos?access_token=" . $this->getToken();
        $response = file_get_contents($link);
        $response = json_decode($response, true);
            var_dump($response);
            exit;
        if ($model->load(Yii::$app->request->post())) {
         $link = "https://graph.facebook.com/funbabyvideos/videos?access_token=" . $this->getToken();
        $response = file_get_contents($link);
        $response = json_decode($response, true);
            var_dump($response);
            exit;
            foreach ($get as $value) {
                $v = $this->getVideo($value[0]['id']);
                $video = new Video();
                $video->title = $result['title'];
                $video->slug = \Yii::$app->convert->string($result['title']);
                $video->author_url = $result['author_url'];
                $video->author_name = $result['author_name'];
                $video->image = $result['thumbnail_url'];
                $video->url = $result['html'];
                $video->category_id = $_POST['category'];
                $video->video_id = $id;
                $video->save();
            }
        }
        return $this->render('index', [
                    'model' => $model,
        ]);
    }

    protected function getVideo($id) {
        $response = file_get_contents('https://graph.facebook.com/' . $id);
        $response = json_decode($response, true);
        return $response;
    }

    protected function lists($id) {
        $link = "https://graph.facebook.com/" . $id . "/videos?access_token=" . $this->getToken();
        $response = file_get_contents($link);
        return json_decode($response, true);
    }

    protected function getToken() {
        return 'EAAEAsDZBmKPsBANXGp2mEMEArnokCqUEi69s2KKTi00u6ZAule5oMQ2Mg2QqP63YwE8rrr6pNHHSLZB1ExZArTgB5ZBfF9BqrYZAQeSSWyvScq9rZBGWJCEeRI1GJVNy3nTGHyRAuoJulJYSZBeRuRqLVEniEFFYE9wvuwsJiZBfE6gZDZD';
    }

}
