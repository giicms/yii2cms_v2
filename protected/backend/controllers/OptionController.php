<?php

namespace backend\controllers;

use Yii;
use common\models\Option;
use common\models\searchs\Option as OptionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BackendController;

/**
 * OptionController implements the CRUD actions for Option model.
 */
class OptionController extends BackendController {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Option models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new OptionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Option model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Option();

        if ($model->load(Yii::$app->request->post())) {
            if (!empty($_POST['img']))
                $model->images = $_POST['img'];
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Đã thêm thành công.');
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Option model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if (!empty($_POST['img']))
                $model->images = $_POST['img'];
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Đã cập nhật thành công.');
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Option model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionStatus() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!empty($_POST['ids'])) {
            foreach ($_POST['ids'] as $value) {
                $model = $this->findModel($value);
                if (!empty($model)) {
                    if ($model->status == Option::PUBLISH_ACTIVE)
                        $model->status = Option::PUBLISH_NOACTIVE;
                    else
                        $model->status = Option::PUBLISH_ACTIVE;
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Đã cập nhật trạng thái thành công.');
                        return $this->redirect(['index']);
                    }
                }
            }
        } elseif (!empty($_POST['id'])) {
            $model = $this->findModel($_POST['id']);
            if (!empty($model)) {
                if ($model->status == Option::PUBLISH_ACTIVE)
                    $model->status = Option::PUBLISH_NOACTIVE;
                else
                    $model->status = Option::PUBLISH_ACTIVE;
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Đã cập nhật trạng thái thành công.');
                }
            }
        }
    }

    /**
     * Finds the Option model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Option the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Option::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
