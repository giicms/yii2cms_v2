<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use common\models\Product;
use common\models\Tree;
use common\models\Treeproduct;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class ProductController extends Controller {

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find()->where(['type' => 'post']),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCategory() {
        $tree = Tree::find()->where(['slug' => $_GET['slug']])->one();
        if (!empty($tree)) {
            $dataProvider = new ActiveDataProvider([
                'query' => Treeproduct::find()->where([ 'tree' => $tree->id]),
            ]);
        } else {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }

        return $this->render('category', [
                    'dataProvider' => $dataProvider,
                    'category' => $tree
        ]);
    }

    public function actionView($id) {

        $model = Product::findOne($id);
        $review = \common\models\Review::find()->where(['user_id' => \Yii::$app->user->id, 'product_id' => $model->id])->one();
        $treeproduct = Treeproduct::find()->where(['product' => $id])->all();
        if (!empty($treeproduct)) {
            foreach ($treeproduct as $value) {
                $ids[] = $value->tree;
            }
        } else {
            $ids = [];
        }
        $dataProvider = new ActiveDataProvider([
            'query' => Treeproduct::find()->where(['IN', 'tree', $ids])->where(['!=', 'product', $id])->limit(12),
        ]);
        $reviewlist = \common\models\Review::find()->where(['product_id' => $model->id])->all();
        if (!empty($model)) {
            return $this->renderAjax('view', [
                        'model' => $model,
                        'dataProvider' => $dataProvider,
                        'review' => !empty($review) ? $review : new \common\models\Review(),
                        'reviewlist' => $reviewlist
            ]);
        }
    }

}
