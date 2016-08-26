<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\bootstrap\ActiveForm;

$this->title = 'Thanh toán';
?>
<div class="col-lg-4">
    <div class="panel panel-default">
        <div class="panel-heading"><?= $this->title ?>
        </div>
        <div class="panel-body">
            <?php
            $form = ActiveForm::begin([
                        'fieldConfig' => [
                            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                            'horizontalCssClasses' => [
                                'label' => 'col-sm-3',
                                'offset' => 'col-sm-offset-3',
                                'wrapper' => ' col-md-9 col-sm-9 col-xs-12',
                                'error' => '',
                                'hint' => '',
                            ],
                        ],
            ]);
            ?> 

            <?= $form->field($model, 'customer_name')->label() ?>
            <?= $form->field($model, 'customer_phone')->label() ?>
            <?= $form->field($model, 'customer_email')->label() ?>
            <?= $form->field($model, 'customer_address')->label() ?>


        </div>
    </div>
</div>

<div class="col-sm-8">
    <div class="panel panel-default">
        <div class="panel-heading">Sản phẩm
        </div>
        <div class="panel-body">
            <?php
            if (!empty($cart)) {
                $stt = 1;
                $price = 0;
                $ids = [];
                foreach ($cart as $key => $value) {
                    $price += $value['price'];
                    $ids[] = $key;
                    ?>
                    <div class="cart-item" data-key="<?= $key ?>">
                        <div class="row">
                            <div class="col-sm-1">
                                <?= $stt++ ?>
                            </div>
                            <div class="col-sm-2">
                                <img style="width: 60px" src="<?= Yii::$app->urlManager->createAbsoluteUrl(['/uploads/thumbs/' . $value['image']]) ?>">
                            </div>
                            <div class="col-sm-4">
                                <?= $value['name'] ?>
                            </div>
                            <div class="col-sm-2">
                                <?= $value['quantity'] ?>
                            </div>
                            <div class="col-sm-2">
                                <?= number_format($value['price'], 0, '', '.') ?> VND
                            </div>
                        </div>

                    </div>
                    <?php
                }
                ?>

                <?php
            }
            ?>

            <?= $form->field($model, 'products')->hiddenInput(['value' => implode(',', $ids)])->label(FALSE) ?>
            <div class="pull-right total-price">
                Total : <span><?= number_format($price, 0, '', '.') ?> VNĐ</span>
                <?= $form->field($model, 'total')->hiddenInput(['value' => $price])->label(FALSE) ?>
                <button type="submit" class="btn btn-danger">Thanh toán</button>
            </div>
        </div>
    </div> 
    <?php
    ActiveForm::end();
    ?>
</div>
