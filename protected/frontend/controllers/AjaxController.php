<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use common\models\Review;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class AjaxController extends Controller {

    public function actionReview() {
        if (Yii::$app->user->isGuest) {
            return $this->renderAjax('_login', ['model' => new \common\models\LoginForm()]);
        }

        if (!empty($_POST['id'])) {
            $video = \common\models\Video::findOne($_POST['id']);
            if (!empty($video->review))
                $model = $video->review;
            else {
                $model = new Review();
                $model->user_id = Yii::$app->user->id;
                $model->product_id = $video->id;
                $model->star = 0;
            }
            return $this->renderAjax('_formReview', ['model' => $model]);
        } else {
            $post = \common\models\Video::findOne($_POST['Review']['product_id']);
            if (!empty($post->review))
                $model = $post->review;
            else
                $model = new Review();

            $model->attributes = $_POST['Review'];
            if ($model->save()) {
                return $this->renderAjax('review', ['model' => Review::find()->where(['product_id' => $model->product_id])->all()]);
            }
        }
    }

    public function actionLogin() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = new \common\models\LoginForm();
        $model->attributes = $_POST['LoginForm'];
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return 'ok';
        }
    }

}
