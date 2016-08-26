<?php

namespace backend\controllers;

use Yii;
use common\models\Post;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BackendController;

/**
 * PostController implements the CRUD actions for Post model.
 */
class BlogController extends BackendController {

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

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Post::find()->where(['type' => 'blog']),
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
        $model = new Post();
        if ($model->load(Yii::$app->request->post())) {
            $model->type = 'blog';
            $model->user_id = \Yii::$app->user->id;
            if (!empty($model->tags))
                $model->tags = implode(',', $model->tags);
            $model->slug = \Yii::$app->convert->string($model->title);

            if (!empty($_POST['img']))
                $model->images = $_POST['img'];
            else
                $model->images = '';
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Đã thêm thành công.');
                return $this->redirect(['create']);
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
            if (!empty($_POST['img']))
                $model->images = $_POST['img'];
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

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
