<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\web\Session;

$session = Yii::$app->session;
$session->get('cart');
?>
<div class="col-sm-5th col-sm-5">
    <div class="box" style="padding:15px 5px;">

        <?php
        $img = explode(',', $model->images);
        ?>
        <a href="#<?= $model->slug ?>" class="item-modal" data-id="<?= $model->id ?>">
            <div style="background-image: url(<?= Yii::$app->urlManager->createAbsoluteUrl(['/uploads/thumbs/' . $img[0]]) ?>);; height:225px; margin-bottom:5px;">
            </div>
        </a>
        <div class="product-review">
            <div class="star">
                <span class="rating-stars-off">★★★★★</span> 
                <span class="rating-stars-on" style="width:0%">★★★★★</span> 

            </div>
        </div>
        <div class="addcart">
            <ul class="list-inline">
                <li><?= number_format($model->price, 0, '', '.') ?> VND</li>
                <li class="pull-right num-cart">
                    <a href="javascript:void(0)" class="btn btn-danger add add_<?= $model->id ?>" data="0"  style="display: <?= !empty($_SESSION['cart'][$model->id]) ? "none" : "block" ?>">
                        Thêm
                    </a>
                    <div class="empty empty_<?= $model->id ?>" style="display: <?= !empty($_SESSION['cart'][$model->id]) ? "block" : "none" ?>">
                        <span class="btn btn-danger addto" data="1"><i class="md md-remove"></i></span>
                        <span class="quantity"><?php
                            if (!empty($_SESSION['cart'][$model->id]['quantity']))
                                echo $_SESSION['cart'][$model->id]['quantity']
                                ?></span>
                        <span class="btn btn-danger addto" data="2"><i class="md md-add"></i></span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>