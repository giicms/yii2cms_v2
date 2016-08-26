<?php

namespace frontend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\Session;
use common\models\Product;
use common\models\Order;

class CartController extends Controller {

    public function actionAdd() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;// Ajax add cart
        $product = \common\models\Treeproduct::findOne($_POST['id']);
        if (!empty($product))
            $id = $product->product;
        else
            $id = $_POST['id'];
        $model = Product::findOne($id);
        if ($_POST['act'] == 2) {
            $total = Yii::$app->session->get('quantity') + 1;
            $quantity = Yii::$app->session['cart'][$model->id]['quantity'] + 1;
            $price = $model->price * $quantity;
        } elseif ($_POST['act'] == 1) {
            $total = Yii::$app->session->get('quantity') - 1;
            $quantity = Yii::$app->session['cart'][$model->id]['quantity'] - 1;
            $price = $model->price * $quantity;
        } else {
            $total = Yii::$app->session->get('quantity') + 1;
            $quantity = 1;
            $price = $model->price * $quantity;
        }
        if ($quantity > 0) {
            $item = [
                "name" => $model->title,
                "image" => explode(',', $model->images)[0],
                "quantity" => $quantity,
                "price" => $price,
            ];
            $cartArray = Yii::$app->session['cart'];// array cart
            $cartArray[$model->id] = $item;
            Yii::$app->session['cart'] = $cartArray;// Save array cart
        } else {
            if (!empty($_SESSION['cart'][$model->id])) {
                unset($_SESSION['cart'][$model->id]);
            }
        }
        Yii::$app->session['quantity'] = $total;// Sum quantity
        return ['quantity' => $quantity, 'total' => $total];
    }

    public function actionBasket() {
        $session = Yii::$app->session;
        $cart = $session->get('cart'); // Get list cart
        $model = new Order();
//        $model->status = 1;
        if ($model->load(Yii::$app->request->post())) {
            $data = [];
            if (!empty($cart)) {
                foreach ($cart as $key => $value) {
                    $data[] = ['image' => $value['image'], 'name' => $value['name'], 'quantity' => $value['quantity'], 'price' => $value['price']];
                }
            }
            $model->products = $data;
            if ($model->save())
                return $this->redirect(['order', 'id' => $model->id]);
        }

        return $this->render('basket', ['cart' => $cart, 'model' => $model]);
    }

    public function actionRemove($id) {

        $session = Yii::$app->session;
        $session->get('cart');
        if (!empty($_SESSION['cart'][$id])) {
            $total = Yii::$app->session->get('quantity') - $_SESSION['cart'][$id]['quantity'];
            Yii::$app->session['quantity'] = $total; // Save quantity
            unset($_SESSION['cart'][$id]);// Delete session item
        } else {
            throw new NotFoundHttpException('This page does not exist in the system.');
        }
        return $this->redirect(['basket']);
    }

    public function actionOrder($id) {
        $model = Order::findOne($id);
        return $this->render('order', ['model' => $model]);
    }

    public function actionCheckout() {
        $cart = Yii::$app->session->get('cart');
        $order = new Order();
        if (!Yii::$app->user->isGuest) {
            $user = \common\models\User::findOne(Yii::$app->user->id);
            $order->attributes = $user->attributes;
            $order->customer_name = $user->lastname . ' ' . $user->firstname;
        }
        return $this->render('checkout', ['model' => $order, 'cart' => $cart]);
    }

}
