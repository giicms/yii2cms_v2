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
                <li><a href="#v-seo" data-toggle="tab" aria-expanded="false">Seo</a></li>

            </ul>
            <div class="tab-content">

                <div class="tab-pane active" id="v-home"> 
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'content')->textarea(['class' => 'summernote']) ?>

                    <div class="form-group">
                        <label class="control-label">Hình ảnh</label>
                        <div class="row ">
                            <div class="col-sm-2">
                                <a href="javascript:void(0)" id="upload"><i class="icon icon-add"></i> <span class="fix">Drop or  upload image file</span></a> 
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

                    <?= $form->field($model, 'tags')->dropDownList($model->tags, ['multiple' => TRUE]); ?>


                </div>
                <div class="tab-pane" id="v-seo"> 
                    <?= $form->field($model, 'keywords')->textInput() ?>
                    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
                </div>
            </div>
        </div> 
    </div>
</div>
<?php ActiveForm::end(); ?>

<?= $this->registerJs("

jQuery(document).ready(function(){
                $('.wysihtml5').wysihtml5();

                $('.summernote').summernote({
                    height: 200,                 // set editor height

                    minHeight: null,             // set minimum height of editor
                    maxHeight: null,             // set maximum height of editor

                    focus: true                 // set focus to editable area after initializing summernote
                });

            });
"); ?>

<?=
$this->registerJs('
$("#post-tags").select2({
  tags: true,
  tokenSeparators: [","]
});

');
?>
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