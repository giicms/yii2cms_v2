<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\tree\TreeViewInput;
use common\models\Treeproduct;
use common\models\Tree;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>
<div class="panel panel-default">
    <div class="panel-heading"><?= $this->title ?>
        <?= Html::submitButton('Lưu', ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>
    </div>
    <div class="panel-body">

        <div class="tabs-vertical-env">
            <ul class="nav tabs-vertical">
                <li class="active"><a href="#v-home" data-toggle="tab" aria-expanded="false">Tổng quan</a></li>
                <li><a href="#v-images" data-toggle="tab" aria-expanded="false">Hình ảnh</a></li>
            </ul>
            <div class="tab-content">

                <div class="tab-pane active" id="v-home"> 
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'description')->textarea() ?>

                    <?= $form->field($model, 'url'); ?>

                </div>

                <div class="tab-pane" id="v-images"> 
                    <div class="form-group">
                        <a href="javascript:void(0)" id="upload"><i class="icon icon-add"></i> <span class="fix">Drop or  upload image file</span></a> 

                    </div>
                    <div class="form-group">
                        <div class="row img-list">
                            <?php
                            if (!empty($model->images)) {
                                foreach (explode(',', $model->images) as $k => $value) {
                                    ?>
                                    <div class="col-md-12 col-sm-12 col-xs-12 img_<?= $k ?>">
                                        <div class="img-tem">
                                            <img style="width:100%" src="/uploads/<?= $value ?>"> 
                                            <input type="hidden" name="img" value="<?= $value ?>"> 
                                           
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
               $(".img-list").html("<div class=\"col-md-12 col-sm-12 col-xs-12 img_"+value[0].id+"\"><div class=\"img-tem\"><img style=\"width:100%\" src=\"/uploads/"+value[0].name+"\"> <input type=\"hidden\" name=\"img\" value="+value[0].name+"></div></div>");
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