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
class VideosController extends BackendController {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionCategory() {

        return $this->render('category');
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Video::find(),
        ]);
        $dataProvider->pagination->pageSize = 50;
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {

        $model = new Video();
        if ($model->load(Yii::$app->request->post())) {
            $url = $this->getVideo($model->url_iframe);
            $model->url = $url['html'];
            $model->image = $url['thumbnail_url'];
            $model->category_id = $_POST['category'];
            $model->status = Video::PUBLISH_ACTIVE;
            $model->user_id = \Yii::$app->user->id;
            if (!empty($model->tags))
                $model->tags = implode(',', $model->tags);
            $model->slug = \Yii::$app->convert->string($model->title);

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Đã thêm thành công.');
                return $this->redirect(['index']);
            }
        }
        $model->tags = [];
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->user_id = \Yii::$app->user->id;
        $data = [];
        if (!empty($model->tags)) {
            foreach (explode(',', $model->tags) as $tag) {
                $data[$tag] = $tag;
            }
        }

        if ($model->load(Yii::$app->request->post())) {
            if (!empty($model->tags))
                $model->tags = implode(',', $model->tags);
            else
                $model->tags = '';
            $model->slug = \Yii::$app->convert->string($model->title);
            $model->category_id = $_POST['category'];
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Đã cập nhật thành công.');
                return $this->redirect(['index', 'page' => $_GET['page']]);
            }
        }
        $model->tags = $data;
        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Đã xóa thành công.');
        return $this->redirect(['index', 'page' => $_GET['page']]);
    }

    public function actionDeletes() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!empty($_POST['ids'])) {
            foreach ($_POST['ids'] as $value) {
                $this->findModel($value)->delete();
            }
        }
        Yii::$app->session->setFlash('success', 'Đã xóa thành công.');
        return $this->redirect(['index', 'page' => $_POST['page']]);
    }

    public function actionStatus() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!empty($_POST['ids'])) {
            foreach ($_POST['ids'] as $value) {
                $model = $this->findModel($value);
                if (!empty($model)) {
                    if ($model->status == Post::PUBLISH_ACTIVE)
                        $model->status = Post::PUBLISH_NOACTIVE;
                    else
                        $model->status = Post::PUBLISH_ACTIVE;
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Đã cập nhật trạng thái thành công.');
                        return $this->redirect(['index', 'page' => $_POST['page']]);
                    }
                }
            }
        } elseif (!empty($_POST['id'])) {
            $model = $this->findModel($_POST['id']);
            if (!empty($model)) {
                if ($model->status == Post::PUBLISH_ACTIVE)
                    $model->status = Post::PUBLISH_NOACTIVE;
                else
                    $model->status = Post::PUBLISH_ACTIVE;
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Đã cập nhật trạng thái thành công.');
                }
            }
        }
    }

    public function actionYoutube() {



        $model = new \common\models\Youtube();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->option == 'channel') {

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
            $video->type = 'youtube';
            $video->save();
        }
    }

    protected function getImage($id) {
        $resolution = array(
            'maxresdefault',
            'sddefault',
            'mqdefault',
            'hqdefault',
            'default'
        );


        $url = '//img.youtube.com/vi/' . $id . '/mqdefault.jpg';

        return $url;
    }

    protected function getIdYoutube($link) {
        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $link, $id);
        if (!empty($id)) {
            return $id = $id[0];
        }
        return $link;
    }

    protected function curl($url) {
        $ch = @curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        $head[] = "Connection: keep-alive";
        $head[] = "Keep-Alive: 300";
        $head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
        $head[] = "Accept-Language: en-us,en;q=0.5";
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        $page = curl_exec($ch);
        curl_close($ch);
        return $page;
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Video::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
