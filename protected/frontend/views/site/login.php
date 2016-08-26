<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Đăng nhập';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-4 col-lg-offset-4">
    <div class="panel panel-default">
        <div class="panel-heading"><?= $this->title ?>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>
            
     

            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <div style="color:#999;margin:1em 0">
                Bạn quên mật khẩu <?= Html::a('Lấy lại mật khẩu', ['site/request-password-reset']) ?>.
            </div>

            <div class="form-group">
                <?= Html::submitButton('Đăng nhập', ['class' => 'btn btn-primary pull-right', 'name' => 'login-button']) ?>
                <?= Html::a('Đăng ký tài khoản', ['site/signup']) ?>.
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
