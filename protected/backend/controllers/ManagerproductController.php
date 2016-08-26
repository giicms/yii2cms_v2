<?php

namespace backend\controllers;

use Yii;
use common\models\ManagerProduct;
use common\models\searchs\ManagerProduct as ManagerProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ManagerproductController implements the CRUD actions for ManagerProduct model.
 */
class ManagerproductController extends Controller {

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
     * Lists all ManagerProduct models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ManagerProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Updates an existing ManagerProduct model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Cập nhật thành công.');
            return $this->redirect(['index', 'page' => $_GET['page']]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ManagerProduct model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Xóa thành công.');
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

    /**
     * Finds the ManagerProduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ManagerProduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ManagerProduct::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
