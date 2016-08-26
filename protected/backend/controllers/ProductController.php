<?php

namespace backend\controllers;

use Yii;
use common\models\Product;
use common\models\searchs\Product as ProductSearch;
use common\models\CategoryPost;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BackendController;

/**
 * ProductController implements the CRUD actions for Post model.
 */
class ProductController extends BackendController {

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
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
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
        $model = new Product();
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = \Yii::$app->user->id;
            if (!empty($model->tags))
                $model->tags = implode(',', $model->tags);
            $model->slug = \Yii::$app->convert->string($model->title);
            $model->price = (int) str_replace('.', '', $model->price);
            $model->price_sale = (int) str_replace('.', '', $model->price_sale);
            if (!empty($_POST['img']))
                $model->images = implode(',', $_POST['img']);
            else
                $model->images = '';
            if ($model->save()) {
                if (!empty($_POST['category'])) {
                    foreach (explode(',', $_POST['category']) as $cat) {
                        $category = \common\models\Tree::findOne($cat);
                        $postcat = new \common\models\Treeproduct();
                        $postcat->tree = $category->id;
                        $postcat->product = $model->id;
                        $postcat->save();
                    }
                }
                Yii::$app->session->setFlash('success', 'Đã thêm thành công.');
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


        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = \Yii::$app->user->id;
            if (!empty($model->tags))
                $model->tags = implode(',', $model->tags);
            $model->slug = \Yii::$app->convert->string($model->title);
            $model->price = (int) str_replace('.', '', $model->price);
            $model->price_sale = (int) str_replace('.', '', $model->price_sale);
            if (!empty($_POST['img']))
                $model->images = implode(',', $_POST['img']);
            $deleteAll = \common\models\Treeproduct::find()->where(['product' => $id])->all();
            if (!empty($deleteAll)) {
                foreach ($deleteAll as $value) {
                    $value->delete();
                }
            }
            if (!empty($_POST['category'])) {
                foreach (explode(',', $_POST['category']) as $cat) {
                    $postcat = new \common\models\Treeproduct();
                    $postcat->tree = $cat;
                    $postcat->product = $id;
                    $postcat->save();
                }
            }
            if ($model->save())
                Yii::$app->session->setFlash('success', 'Đã cập nhật thành công.');
            return $this->redirect(['index', 'page' => $_GET['page']]);
        }
        if (!empty($model->tags)) {
            foreach (explode(',', $model->tags) as $tag) {
                $tags[$tag] = $tag;
            }
        } else
            $tags = [];

        $model->tags = $tags;
        $model->price = number_format($model->price, 0, '', '.');
        $model->price_sale = number_format($model->price_sale, 0, '', '.');
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
        return $this->redirect(['index']);
    }

    public function actionStatus() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!empty($_POST['ids'])) {
            foreach ($_POST['ids'] as $value) {
                $model = $this->findModel($value);
                if (!empty($model)) {
                    if ($model->status == Product::PUBLISH_ACTIVE)
                        $model->status = Product::PUBLISH_NOACTIVE;
                    else
                        $model->status = Product::PUBLISH_ACTIVE;
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Đã cập nhật trạng thái thành công.');
                    }
                }
            }
        } elseif (!empty($_POST['id'])) {
            $model = $this->findModel($_POST['id']);
            if (!empty($model)) {
                if ($model->status == Product::PUBLISH_ACTIVE)
                    $model->status = Product::PUBLISH_NOACTIVE;
                else
                    $model->status = Product::PUBLISH_ACTIVE;
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Đã cập nhật trạng thái thành công.');
                }
            }
        }

        return 'ok';
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
