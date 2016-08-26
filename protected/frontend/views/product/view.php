<?php

use yii\widgets\ListView;
use yii\web\Session;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$session = Yii::$app->session;
$session->get('cart');
?>
<div class="product-detail">
    <div class="row">
        <div class="col-sm-12">
            <button type="button" class="close close-modal">×</button>
        </div>
        <div class="col-sm-7">
            <?php
            $img = explode(',', $model->images);
            ?>
            <img width="90%" src="<?= Yii::$app->urlManager->createAbsoluteUrl(['/uploads/smalls/' . $img[0]]) ?>">
        </div>
        <div class="col-sm-5">
            <h4><?= $model->title ?> </h4>
            <div style="height:35px;">
                <div class="star">
                    <span class="rating-stars-off">★★★★★</span> 
                    <span class="rating-stars-on" style="width:<?= ($model->countRating * 10) > 0 ? $model->countRating * 10 : 12 ?>%">★★★★★</span> 

                </div>
            </div>
            <div>
                <?= number_format($model->price, 0, '', '.') ?> VND
            </div>
            <div class="addcart">
                <a href="javascript:void(0)" width="100" class="btn btn-danger add-detail add_<?= $model->id ?>" data="0"  style="display: <?= !empty($_SESSION['cart'][$model->id]) ? "none" : "block" ?>">
                    Thêm vào
                </a>
                <div class="empty empty_<?= $model->id ?>" style="display: <?= !empty($_SESSION['cart'][$model->id]) ? "block" : "none" ?>">
                    <span class="btn btn-danger addto-detail" data="1"><i class="md md-remove"></i></span>
                    <span class="quantity"><?php
                        if (!empty($_SESSION['cart'][$model->id]['quantity']))
                            echo $_SESSION['cart'][$model->id]['quantity']
                            ?></span>
                    <span class="btn btn-danger addto-detail" data="2"><i class="md md-add"></i></span>
                </div>
            </div>
            <p>
                <?= $model->content ?>
            </p>
            <p>Phí vận chuyển: 20.000 VNĐ</p>
        </div>
    </div>
    <div style="margin-top: 20px">
        <div class="row">
            <div class="col-lg-12">
                <ul class="nav nav-tabs tabs tabs-top">
                    <li class="active tab">
                        <a href="#tab-1" data-toggle="tab" aria-expanded="false">
                            <span class="visible-xs"><i class="fa fa-home"></i></span>
                            <span class="hidden-xs">Tổng quan</span>
                        </a>
                    </li>
                    <li class="tab">
                        <a href="#tab-2" data-toggle="tab" aria-expanded="false">
                            <span class="visible-xs"><i class="fa fa-user"></i></span>
                            <span class="hidden-xs">Sản phẩm liên quan</span>
                        </a>
                    </li>
                    <li class="tab">
                        <a href="#tab-3" data-toggle="tab" aria-expanded="true">
                            <span class="visible-xs"><i class="fa fa-envelope-o"></i></span>
                            <span class="hidden-xs">Đánh giá sản phẩm</span>
                        </a>
                    </li>


                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-1">
                        <?= $model->content ?> 
                    </div>
                    <div class="tab-pane" id="tab-2">
                        <?=
                        ListView::widget([
                            'dataProvider' => $dataProvider,
                            'options' => [
                                'tag' => 'div',
                                'class' => 'list-wrapper',
                                'id' => 'list-wrapper',
                            ],
                            'layout' => "{items}\n{pager}",
                            'itemView' => '_col3',
                        ]);
                        ?> </div>
                    <div class="tab-pane" id="tab-3">
                        <?php
                        if (!Yii::$app->user->isGuest) {
                            ?>
                            <p class="success-review alert"></p>
                            <?php
                            $form = ActiveForm::begin(['id' => 'formReview']);
                            ?> 
                            <?= $form->field($review, 'id')->hiddenInput()->label(FALSE) ?>
                            <?= $form->field($review, 'star')->hiddenInput()->label(FALSE) ?>
                            <?= $form->field($review, 'user_id')->hiddenInput(['value' => Yii::$app->user->id])->label(FALSE) ?>
                            <?= $form->field($review, 'product_id')->hiddenInput(['value' => $model->id])->label(FALSE) ?>

                            <div class="inbox-widget">
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="/uploads/thumbs/<?= Yii::$app->user->identity->avatar ?>" class="img-circle" alt=""></div>

                                    <div style="margin-left: 50px;">
                                        <h5><?= Yii::$app->user->identity->lastname . ' ' . Yii::$app->user->identity->firstname ?></h5>
                                        <div class="form-group">
                                            <?= \frontend\components\widgets\RatingWidget::widget(['id' => $model->id, 'rating' => $review->star]) ?>
                                        </div>

                                        <?= $form->field($review, 'content')->textarea()->label(FALSE) ?>
                                        <div class="form-group" >
                                            <?= Html::submitButton('Gởi', ['class' => 'btn btn-primary pull-right']) ?>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <?php ActiveForm::end(); ?>
                            <?php
                        } else {
                            echo 'Bạn phải đăng nhập để đánh giá sản phẩm này';
                        }
                        ?>
                        <div class="inbox-widget">
                            <?php
                            if (!empty($reviewlist)) {
                                foreach ($reviewlist as $value) {
                                    ?>
                                    <a href="#">
                                        <div class="inbox-item">
                                            <div class="inbox-item-img"><img src="/uploads/thumbs/<?= $value->user->avatar ?>" class="img-circle" alt=""></div>
                                            <p class="inbox-item-author"><?= $value->user->lastname . ' ' . $value->user->firstname ?></p>
                                            <div style="height:25px; margin-left: 53px; overflow: hidden; margin: 10px 0">
                                                <div class="review-detail">
                                                    <label class="<?= ($value->star >= 1) ? "active" : "" ?>"></label>
                                                    <label class="<?= ($value->star >= 2) ? "active" : "" ?>"></label>
                                                    <label class="<?= ($value->star >= 3) ? "active" : "" ?>"></label>
                                                    <label class="<?= ($value->star >= 4) ? "active" : "" ?>"></label>
                                                    <label class="<?= ($value->star >= 5) ? "active" : "" ?>"></label>
                                                </div>
                                            </div>
                                            <p class="inbox-item-text" style="margin-left:55px"><?= $value->content ?></p>
                                            <p class="inbox-item-date">13:40 PM</p>
                                        </div>
                                    </a>
                                    <?php
                                }
                            }
                            ?>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= $this->registerJs('
$(".add-detail").on("click", function(event, state) {
    var key = "' . $model->id . '";
    var act = $(this).attr("data");
        $.ajax({
        type: "POST",
        url:"' . Yii::$app->urlManager->createUrl(["cart/add"]) . '",
             data: {id: key,act:act},
            success: function (data) {
                $(".quantity").text(data.quantity);
                $(".add_"+key).hide();
                $(".empty_"+key).show();
                   if(data.total>0){
                $(".numcart span").text(data.total);
                } else {
                 $(".numcart span").text("");
                }
            }, 
        });
});
') ?>

    <?= $this->registerJs('
$(".addto-detail").on("click", function(event, state) {
    var key = "' . $model->id . '";
    var act = $(this).attr("data");
        $.ajax({
        type: "POST",
        url:"' . Yii::$app->urlManager->createUrl(["cart/add"]) . '",
             data: {id: key,act:act},
            success: function (data) {
            if(data.quantity > 0){
            $(".empty_"+key+" .quantity").text(data.quantity);
            } else {
                $(".add_"+key).show();
                $(".empty_"+key).hide();
            }
               if(data.total>0){
                $(".numcart span").text(data.total);
                } else {
                 $(".numcart span").text("");
                }
            }, 
        });
});
') ?>

    <?= $this->registerJs('
$(".add").on("click", function(event, state) {
    var key = $(this).parent().parent().parent().parent().parent().parent("div").attr("data-key");
    var act = $(this).attr("data");
        $.ajax({
        type: "POST",
        url:"' . Yii::$app->urlManager->createUrl(["cart/add"]) . '",
             data: {id: key,act:act},
            success: function (data) {
                $(".quantity").text(data.quantity);
                $(".add_"+key).hide();
                $(".empty_"+key).show();
                   if(data.total>0){
                $(".numcart span").text(data.total);
                } else {
                 $(".numcart span").text("");
                }
            }, 
        });
});
') ?>

    <?= $this->registerJs('
$(".addto").on("click", function(event, state) {
    var key = $(this).parent().parent().parent().parent().parent().parent().parent("div").attr("data-key");
    var act = $(this).attr("data");
        $.ajax({
        type: "POST",
        url:"' . Yii::$app->urlManager->createUrl(["cart/add"]) . '",
             data: {id: key,act:act},
            success: function (data) {
            if(data.quantity > 0){
            $(".empty_"+key+" .quantity").text(data.quantity);
            } else {
                $(".add_"+key).show();
                $(".empty_"+key).hide();
            }
               if(data.total>0){
                $(".numcart span").text(data.total);
                } else {
                 $(".numcart span").text("");
                }
            }, 
        });
});
') ?>
    <?= $this->registerJs("$(document).on('submit', '#formReview', function (event){
        event.preventDefault();
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["ajax/review"]) . "',
            type: 'post',
            data: $('form#formReview').serialize(),
            success: function(data) {
            if(data){
            $('.success-review').html('Đánh giá thành công');
                }
            }
        });

});") ?>