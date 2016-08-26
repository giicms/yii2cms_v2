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
                <li><a href="#v-options" data-toggle="tab" aria-expanded="false">Tùy chọn</a></li>
                <li><a href="#v-seo" data-toggle="tab" aria-expanded="false">Seo</a></li>

            </ul>
            <div class="tab-content">

                <div class="tab-pane active" id="v-home"> 
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                    <div class="form-group">
                        <label class="control-label">Danh mục</label>
                        <?php
                        if (!empty($model->tree)) {
                            foreach ($model->tree as $value) {
                                $id[] = $value->id;
                            }
                            $id = implode(',', $id);
                        } else
                            $id = '1';
                        echo TreeViewInput::widget([
                            // single query fetch to render the tree
                            'query' => \common\models\Tree::find()->where(['type' => 'product'])->addOrderBy('root, lft'),
                            'headingOptions' => ['label' => 'Categories'],
                            'name' => 'category', // input name
                            'value' => $id, // values selected (comma separated for multiple select)
                            'asDropdown' => true, // will render the tree input widget as a dropdown.
                            'multiple' => true, // set to false if you do not need multiple selection
                            'fontAwesome' => true, // render font awesome icons
                            'rootOptions' => [
                                'label' => '<i class="fa fa-tree"></i>',
                                'class' => 'text-success'
                            ], // custom root label
                                //'options'         => ['disabled' => true],
                        ]);
                        ?>


                    </div>

                    <?= $form->field($model, 'content')->textarea(['class' => 'summernote']) ?>

                    <?= $form->field($model, 'tags')->dropDownList($model->tags, ['multiple' => TRUE]); ?>

                </div>
                <div class="tab-pane" id="v-seo"> 
                    <?= $form->field($model, 'keywords')->textInput() ?>
                    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
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
                                    <div class="col-md-2 col-sm-2 col-xs-4 img_<?= $k ?>">
                                        <div class="img-tem">
                                            <img class="img-rounded"  style="width:100px" src="/uploads/thumbs/<?= $value ?>"> 
                                            <input type="hidden" name="img[]" value="<?= $value ?>"> 
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
                <div class="tab-pane" id="v-options">
                    <div class="row">
                        <div class="col-sm-4">
                            <?= $form->field($model, 'price') ?>
                            <?= $form->field($model, 'price_sale') ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($model, 'color'); ?>
                            <?= $form->field($model, 'size'); ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($model, 'number'); ?>
                            <?= $form->field($model, 'options')->dropDownList(yii\helpers\ArrayHelper::map(\common\models\Option::find()->all(), 'key', 'title'), ['prompt' => 'Tùy chọn']); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>
<?php ActiveForm::end(); ?>

<?= $this->registerJs("
        $('#product-price').keyup(function(event) {
    if(event.which >= 37 && event.which <= 40){
    event.preventDefault();
  }

  $(this).val(function(index, value) {
    return value
      .replace(/\D/g, '')
      .replace(/([0-9])([0-9]{3})$/, '$1.$2')  
      .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, '.')
    ;
  });
});

        $('#product-price_sale').keyup(function(event) {
    if(event.which >= 37 && event.which <= 40){
    event.preventDefault();
  }

  $(this).val(function(index, value) {
    return value
      .replace(/\D/g, '')
      .replace(/([0-9])([0-9]{3})$/, '$1.$2')  
      .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, '.')
    ;
  });
});

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
$("#product-tags").select2({
  tags: true,
  tokenSeparators: [","]
});

');
?>
<?=
$this->registerJs('$(document).ready(function ()
{

      $("#upload").uploadFile({
        url: "' . Yii::$app->urlManager->createUrl(["upload/multiple"]) . '",
        method: "POST",
        allowedTypes: "jpg,png,jpeg,gif",
        fileName: "myfile",
        multiple: true,
       onBeforeSend: function () {
            $(".loading-img").html("Dang tải...");
        },

             onSuccess: function (files, data, xhr)
        {
               $.each(data, function (index, value) {
               $(".img-list").append("<div class=\"col-md-2 col-sm-2 col-xs-4 img_"+value[0].id+"\"><div class=\"img-tem\"><img class=\"img-rounded\"  style=\"width:100px\" src="+value[0].url+"> <input type=\"hidden\" name=\"img[]\" value="+value[0].name+"> <a class=\deleteFile\ href=\javascript:void(0)\ data-img="+value[0].name+" id="+value[0].id+"><i class=\"fa fa-trash-o\"></i></a></div></div>");
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