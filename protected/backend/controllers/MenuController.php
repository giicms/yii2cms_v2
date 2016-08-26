<?php

namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use common\models\Post;
use common\models\Menu;
use common\models\MenuItem;
use backend\controllers\BackendController;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MenuController extends BackendController {

    /**
     * @inheritdoc
     */
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex() {
        $menu = Menu::find()->all();
        if (!empty($menu))
            return $this->redirect(['view', 'id' => $menu[0]->id]);
        else
            return $this->redirect(['create']);
    }

    public function actionCreate() {
        $model = new Menu();
        $tree = \common\models\Tree::find()->where(['active' => 1])->addOrderBy('root, lft')->all();
        $page = Post::find()->where(['type' => 'page'])->all();
        if ($model->load(Yii::$app->request->post())) {
            $model->active = 1;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Đã thêm thành công.');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'page' => $page,
                        'tree' => $tree
            ]);
        }
    }

    public function actionView($id) {
        $category = \common\models\Tree::find()->where(['active' => 1])->addOrderBy('root, lft')->all();
        $page = Post::find()->where(['type' => 'page'])->all();
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            if (isset($_POST['delete'])) {
                Menu::findOne($id)->delete();
                MenuItem::deleteAll(['menu_id' => $id]);
                Yii::$app->session->setFlash('success', 'Đã xóa thành công.');
                $menu = Menu::find()->all();
                if (!empty($menu))
                    return $this->redirect(['view', 'id' => $menu[0]->id]);
                else
                    return $this->redirect(['create']);
            } else {
                if (!empty($_POST['tree'])) {
                    foreach ($_POST['tree'] as $value) {
                        $category = \common\models\Tree::findOne($value);
                        $menuitem = new MenuItem();
                        $menuitem->menu_id = $id;
                        $menuitem->type_id = $category->id;
                        $menuitem->type = 'tree';
                        $menuitem->type_name = $category->name;
                        $menuitem->type_slug = $category->slug;
                        $menuitem->order = 0;
                        $menuitem->save();
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                if (!empty($_POST['page'])) {
                    foreach ($_POST['page'] as $value) {
                        $page = Post::findOne($value);
                        $menuitem = new MenuItem();
                        $menuitem->menu_id = $id;
                        $menuitem->type_id = $page->id;
                        $menuitem->type = 'page';
                        $menuitem->type_name = $page->title;
                        $menuitem->type_slug = $page->slug;
                        $menuitem->order = 0;
                        $menuitem->save();
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }
        $menuitem = MenuItem::find()->where(['menu_id' => $id])->orderBy(['order' => SORT_ASC])->all();
        $menuall = Menu::find()->all();
        return $this->render('view', ['category' => $category, 'page' => $page, 'model' => $model, 'menuitem' => $menuitem, 'menuall' => $menuall]);
    }

    public function actionSave() {
        foreach ($_POST['list'] as $key => $value) {
            $menuitem = MenuItem::findOne($value['id']);
            $menuitem->parent_id = 0;
            $menuitem->order = $key;
            $menuitem->save();
            if (!empty($value['children'])) {
                $this->save($value['children'], $value['id']);
            }
        }
    }

    protected function save(&$data, $parent) {
        foreach ($data as $key => $value) {
            $menuitem = MenuItem::findOne($value['id']);
            $menuitem->order = $key;
            $menuitem->parent_id = $parent;
            $menuitem->save();
            if (!empty($value['children']))
                $this->save($value['children'], $value['id']);
        }
    }

    public function actionDeleteitem($id) {
        $menuitem = MenuItem::findOne($id);
        $menuitem->delete();
        Yii::$app->session->setFlash('success', 'Đã xóa thành công.');
        return $this->redirect(['view', 'id' => $menuitem->menu_id]);
    }

    public function actionEdit() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!empty($_POST['Menu']['id'])) {
            $menu = Menu::findOne($_POST['Menu']['id']);
            $menu->name = $_POST['menu-name'];
            $menu->save();
            if (!empty($_POST['order'])) {
                foreach ($_POST['order'] as $key => $value) {
                    $item = MenuItem::findOne($value);
                    $item->parent_id = $_POST['parent'][$value];
                    $item->type_name = $_POST['name'][$value];
                    $item->order = $key + 1;
                    $item->save();
                }
            }
            return ['message' => 'ok'];
        }
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $item = MenuItem::find()->where(['menu_id' => $id])->all();
        if (!empty($item)) {
            foreach ($item as $value) {
                MenuItem::findOne($value->id)->delete();
            }
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id) {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
