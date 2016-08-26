<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Account */

$this->title = 'Thay đổi mật khẩu';
$this->params['breadcrumbs'][] = ['label' => 'Thông tin cá nhân', 'url' => ['profile']];
$this->params['breadcrumbs'][] = 'Thay đổi mật khẩu';
?>
<div class="panel panel-default">
    <div class="panel-heading"><?= $this->title ?>
        <?= Html::submitButton('Lưu', ['class' => 'btn btn-success pull-right']) ?>
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']]); ?>  
        <?php if (Yii::$app->session->hasFlash('success')) { ?>
            <div class="alert alert-success" role="alert">
                <?= Yii::$app->session->getFlash('success') ?>
            </div>
        <?php } ?>
        <?= $form->field($model, 'password', ['template' => '<label class="col-md-2 col-sm-4 col-xs-12 control-label">' . $model->getAttributeLabel('password') . '</label><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->passwordInput() ?>
        <?= $form->field($model, 'password_new', ['template' => '<label class="col-md-2 col-sm-4 col-xs-12 control-label">' . $model->getAttributeLabel('password_new') . '</label><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->passwordInput() ?>
        <?= $form->field($model, 'password_repeat', ['template' => '<label class="col-md-2 col-sm-4 col-xs-12 control-label">' . $model->getAttributeLabel('password_repeat') . '</label><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->passwordInput() ?>


        <?php ActiveForm::end(); ?>
    </div>
</div>

