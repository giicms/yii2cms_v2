<?php

namespace backend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;
use common\models\searchs\User as UserSearch;
use backend\models\SignupForm;
use backend\models\ProfileForm;
use backend\models\PasswordForm;

/**
 * Site controller
 */
class UserController extends Controller {

    /**
     * @inheritdoc
     */
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
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate() {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {

            if ($user = $model->signup()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    public function actionUpdate($id) {
        $model = new ProfileForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->profile()) {
                Yii::$app->getSession()->setFlash('success', 'Cập nhật thành công!');
                return $this->redirect(['index', 'page' => $_GET['page']]);
            }
        }
        $user = User::findOne($id);

        return $this->render('update', [
                    'model' => $model,
                    'user' => $user
        ]);
    }

    public function actionDelete($id) {
        $this->findModel($id)->delete();
        Yii::$app->getSession()->setFlash('success', 'Xóa thành công!');
        return $this->redirect(['index', 'page' => $_GET['page']]);
    }

    public function actionProfile() {
        $model = new ProfileForm();
        if ($model->load(Yii::$app->request->post())) {
            if (!empty($_POST['img'])) {
                $model->avatar = $_POST['img'];
            } else
                $model->avatar = Yii::$app->user->identity->avatar;
            if ($user = $model->profile()) {
                Yii::$app->getSession()->setFlash('success', 'Bạn đã cập nhật thành công!');
                return $this->redirect(['profile']);
            }
        }
        $user = $this->findModel(\Yii::$app->user->id);
        return $this->render('profile', [
                    'model' => $model,
                    'user' => $user
        ]);
    }

    public function actionChangepassword() {
        $model = new PasswordForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->change()) {
                Yii::$app->getSession()->setFlash('success', 'Bạn đã thay đổi mật khẩu thành công!');
                return $this->redirect(['changepassword']);
            }
        }
        $user = $this->findModel(\Yii::$app->user->id);
        return $this->render('changepassword', [
                    'model' => $model,
                    'user' => $user
        ]);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
