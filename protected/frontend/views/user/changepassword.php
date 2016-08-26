<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Account */

$this->title = 'Thay đổi mật khẩu';
$this->params['breadcrumbs'][] = ['label' => 'Thông tin cá nhân', 'url' => ['profile']];
$this->params['breadcrumbs'][] = 'Thay đổi mật khẩu';
?>
<div class="col-lg-4 col-lg-offset-4">
    <div class="panel panel-default">
        <div class="panel-heading"><?= $this->title ?>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(); ?>  

            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'password_new')->passwordInput() ?>
            <?= $form->field($model, 'password_repeat')->passwordInput() ?>
            <div class="form-group">
                <?= Html::submitButton('Lưu', ['class' => 'btn btn-success pull-right']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

