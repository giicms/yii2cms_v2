<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use common\models\Post;
use common\models\Category;
use common\models\CategoryPost;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SearchController extends Controller {

    public function actionIndex($key) {
        $dataProvider = new ActiveDataProvider([
            'query' => Post::find()->where(['like', 'title', $key]),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'key' => $key
        ]);
    }

}
