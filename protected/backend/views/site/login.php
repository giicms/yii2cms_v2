<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Đăng nhập';
?>

<?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'form-horizontal m-t-20']]); ?>
<?= $form->field($model, 'username')->textInput(['placeholder' => 'Tên đăng nhập']) ?>
<?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Nhập mật khẩu']) ?>

<div class="form-group text-center m-t-40">
    <div class="col-xs-12">
        <?= Html::submitButton('Đăng nhập', ['class' => 'btn btn-primary btn-lg w-lg waves-effect waves-light', 'name' => 'login-button']) ?>
    </div>
</div>
<div class="form-group m-t-30">
    <div class="col-sm-7">
        <a href="#"><i class="fa fa-lock m-r-5"></i> Quên mật khẩu?</a>
    </div>
  
</div>
<?php ActiveForm::end(); ?>