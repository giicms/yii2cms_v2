<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use common\models\Video;
use common\models\Tree;

/**
 * Site controller
 */
class VideoController extends Controller {

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Video::find()->orderBy(['created_at' => SORT_DESC]),
        ]);
        $dataProvider->pagination->pageSize = 50;
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCategory() {
        $tree = Tree::find()->where(['slug' => $_GET['slug']])->one();
        if (!empty($tree)) {
            $dataProvider = new ActiveDataProvider([
                'query' => Video::find()->where([ 'category_id' => $tree->id])->orderBy(['created_at' => SORT_DESC]),
            ]);
            $dataProvider->pagination->pageSize = 50;
        } else {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'category' => $tree
        ]);
    }

    public function actionView($slug) {

        $model = Video::find()->where(['slug' => $slug])->one();
        $dataProvider = new ActiveDataProvider([
            'query' => Video::find()->where(['>', 'id', $model->id])->andWhere(['category_id' => $model->category_id]),
        ]);

        if (!empty($model)) {
            $reviewlist = \common\models\Review::find()->where(['product_id' => $model->id])->all();
            return $this->render('view', [
                        'model' => $model,
                        'dataProvider' => $dataProvider,
                        'review' => !empty($review) ? $review : new \common\models\Review(),
                        'reviewlist' => $reviewlist
            ]);
        } else {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

    public function actionGetlink() {
        $model = new \common\models\Youtube();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->option == 'channel') {
                $this->getChannel($model);
            } else {
                $this->getVideoId($model->channelId);
            }
            Yii::$app->session->setFlash('success', 'Đã thêm thành công.');
            return $this->redirect(['index']);
        }
        return $this->render('youtube', [
                    'model' => $model,
        ]);
    }

    protected function getChannel($model) {
        $Youtube_API_Key = "AIzaSyAQDzK584gGmNV7enH8qQeX6rLd_P42Nks"; // you can obtain api key :  https://developers.google.com/youtube/registering_an_application
        $Youtube_channel_id = $model->channelId;
        $TotalVideso = $model->total; // 50 is max , if you want more video you need Youtube secret key.
        $order = "date"; ////allowed order : date,rating,relevance,title,videocount,viewcount
        $url = "https://www.googleapis.com/youtube/v3/search?key=" . $Youtube_API_Key . "&channelId=" . $Youtube_channel_id . "&part=id&order=" . $order . "&maxResults=" . $TotalVideso . "&format=json";
        $data = file_get_contents($url);
        $JsonDecodeData = json_decode($data, true);
        if (!empty($JsonDecodeData)) {
            foreach ($JsonDecodeData['items'] as $value) {
                if (!empty($value['id']['videoId'])) {
                    $this->getVideoId($value['id']['videoId']);
                }
            }
        }
    }

    protected function getVideoId($id) {
        $check = Video::find()->where(['video_id' => $id])->one();
        if (!$check) {
            $getlink = "https://www.youtube.com/watch?v=" . $id;
            $url = "http://www.youtube.com/oembed?url=" . $getlink . "&format=json";
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $return = curl_exec($curl);
            curl_close($curl);
            $result = json_decode($return, true);

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

}
