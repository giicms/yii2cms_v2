<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Option */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>
<div class="panel panel-default">
    <div class="panel-heading"><?= $this->title ?>
        <?= Html::submitButton('Lưu', ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>
    </div>
    <div class="panel-body">



        <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

        <div class="form-group">
            <label class="control-label">Hình ảnh</label>
            <div class="row ">
                <div class="col-sm-2">
                    <a href="javascript:void(0)" id="upload"  style="margin:10px"><i class="icon icon-add"></i> <span class="fix">Drop or  upload image file</span></a> 
                </div>
                <div class="img-list">
                    <?php
                    if (!empty($model->images)) {
                        foreach (explode(',', $model->images) as $k => $value) {
                            ?>

                            <div class="col-md-2 col-sm-2 col-xs-4 img_<?= $k ?>">
                                <div class="img-tem">
                                    <img style="width:150px" src="/uploads/thumbs/<?= $value ?>"> 
                                    <input type="hidden" name="img" value="<?= $value ?>"> 
                                    <a class="deleteFile" href="javascript:void(0)" data-img="<?= $value ?>" id="<?= $k ?>"><i class="fa fa-trash-o"></i></a>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>




    </div>
</div>

<?php ActiveForm::end(); ?>

<?=
$this->registerJs('$(document).ready(function ()
{

      $("#upload").uploadFile({
        url: "' . Yii::$app->urlManager->createUrl(["upload/simple"]) . '",
        method: "POST",
        allowedTypes: "jpg,png,jpeg,gif",
        fileName: "myfile",
        multiple: false,
       onBeforeSend: function () {
            $(".loading-img").html("Dang tải...");
        },

             onSuccess: function (files, data, xhr)
        {
               $.each(data, function (index, value) {
               $(".img-list").html("<div class=\"col-md-2 col-sm-2 col-xs-4 img_"+value[0].id+"\"><div class=\"img-tem\"><img style=\"width:150px\" src="+value[0].url+"> <input type=\"hidden\" name=\"img\" value="+value[0].name+"> <a class=\deleteFile\ href=\javascript:void(0)\ data-img="+value[0].name+" id="+value[0].id+"><i class=\"fa fa-trash-o\"></i></a></div></div>");
            });
        },
        onError: function (files, status, errMsg)
        {
            $(".img-project").html("Không đúng định dạng hoặc size quá lớn");
        }
    });
 $(document).on("click", ".deleteFile", function () {
        var comfirm = confirm("Bạn có muốn xóa cái file không");
        var id =$(this).attr("id");
        if(comfirm){
          $(".img_"+id).remove();
   
        }
    });
})');
?>