<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Menu;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\AuthItem */
/* @var $context mdm\admin\components\ItemController */

$this->title = 'Chỉnh sửa thông tin';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->firstname . ' ' . $user->lastname, 'url' => ['assignment/view', 'id' => $user->id]];
?>

<?php $form = ActiveForm::begin(['id' => 'profile-form']); ?>
<div class="panel panel-default">
    <div class="panel-heading"><?= $this->title ?>
        <?php
//        echo Menu::widget([
//            'items' => [
//                ['label' => 'Thay đổi mật khẩu', 'template' => '<a href="{url}" class="btn-success">{label}</a>', 'url' => [ 'changepassword']]
//            ],
//            'options' => [ 'class' => 'nav navbar-right panel_toolbox'],
//        ]);
        ?>
        <?= Html::submitButton('Lưu', ['class' => 'btn btn-success pull-right']) ?>
    </div>
    <div class="panel-body">
        <div class="tabs-vertical-env">
            <ul class="nav tabs-vertical">
                <li class="active"><a href="#v-home" data-toggle="tab" aria-expanded="false">Tổng quan</a></li>
                <li><a href="#v-rules" data-toggle="tab" aria-expanded="false">Phân quyền</a></li>

            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="v-home"> 
                    <div class="form-group">
                        <label class="control-label">Ảnh đại diện</label>
                        <div class="row ">
                            <div class="col-sm-2">
                                <a href="javascript:void(0)" id="upload"><i class="icon icon-add"></i> <span class="fix">Drop or  upload image file</span></a> 
                            </div>
                            <div class="img-list">
                                <?php
                                if (!empty($user->avatar)) {
                                        ?>
                                        <div class="col-md-2 col-sm-2 col-xs-4 img_1">
                                            <div class="img-tem">
                                                <img style="width:150px" src="/uploads/thumbs/<?= $user->avatar ?>"> 
                                                <input type="hidden" name="img" value="<?= $user->avatar ?>"> 
                                                <a class="deleteFile" href="javascript:void(0)" data-img="<?= $user->avatar ?>" id="1"><i class="fa fa-trash-o"></i></a>
                                            </div>
                                        </div>
                                        <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <?= $form->field($model, 'username')->textInput(['value' => $user->username]) ?>

                    <?= $form->field($model, 'email')->textInput(['value' => $user->email]) ?>

                    <?= $form->field($model, 'firstname')->textInput(['value' => $user->firstname]) ?>

                    <?= $form->field($model, 'lastname')->textInput(['value' => $user->lastname]) ?>
                    <?= $form->field($model, 'id')->hiddenInput(['value' => $user->id])->label(FALSE) ?>
                </div>
                <div class="tab-pane" id="v-rules"> Phân quyền </div>
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