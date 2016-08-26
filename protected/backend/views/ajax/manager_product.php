<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\ManagerProduct;

/* @var $this yii\web\View */
/* @var $model common\models\Option */
/* @var $form yii\widgets\ActiveForm */
?>



<?php $form = ActiveForm::begin(['id' => 'formAjax']); ?>
<DIV class="message">
    <?php
    if (!empty($export)) {
        echo 'Sản phẩm này mới nhập kho lần gần đây nhất vào ngày: ' . date('d/m/Y h:i', $export[0]->created_at);
    } elseif (!empty($import)) {
        echo 'Sản phẩm này mới xuất kho lần gần đây nhất vào ngày: ' . date('d/m/Y h:i', $import[0]->created_at);
    }
    ?>
</DIV>
<?= $form->field($model, 'product_id')->hiddenInput()->label(FALSE) ?>
<?= $form->field($model, 'status')->dropDownList([ManagerProduct::STATUS_EXPORT => 'Xuất kho', ManagerProduct::STATUS_IMPORT => 'Nhập kho']); ?>
<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>
<?=
$form->field($model, 'date')->widget(\yii\jui\DatePicker::classname(), [
    //'language' => 'ru',
    'dateFormat' => 'dd/MM/yyyy',
])
?>
<?= Html::submitButton('Lưu', ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>

<?php ActiveForm::end(); ?>

<?= $this->registerJs("$(document).on('submit', '#formAjax', function (event){
        event.preventDefault();
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["ajax/managerproduct"]) . "',
            type: 'post',
            data: $('form#formAjax').serialize(),
            success: function(data) {
            if(data){
                  $('.message').html('<div class=\"alert alert-success\" role=\"alert\">Đã nhập hàng thành công</div>')
                }
            }
        });

});") ?>