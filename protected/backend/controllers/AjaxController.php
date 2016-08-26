<?php

namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveRecord;
use common\models\Product;
use common\models\ManagerProduct;

class AjaxController extends Controller {

    public function actionManagerproduct() {

        $model = new ManagerProduct();
        $request = \Yii::$app->getRequest();
        if ($model->load($request->post())) {
            $model->user_id = \Yii::$app->user->id;
            $model->created_at = time();
            if ($model->save())
                echo 'ok';
            exit;
        }

        $product = Product::findOne($_POST['id']);
        $model->product_id = $product->id;
        $model->name = $product->title;
        $export = ManagerProduct::find()->where(['product_id' => $_POST['id'], 'status' => ManagerProduct::STATUS_EXPORT])->orderBy(['created_at' => SORT_DESC])->limit(1)->all();
        $import = ManagerProduct::find()->where(['product_id' => $_POST['id'], 'status' => ManagerProduct::STATUS_IMPORT])->orderBy(['created_at' => SORT_DESC])->limit(1)->all();
        return $this->renderAjax('manager_product', ['model' => $model, 'import' => $import, 'export' => $export]);
    }

}
