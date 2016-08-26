<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Đăng ký';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-4 col-lg-offset-4">
    <div class="panel panel-default">
        <div class="panel-heading"><?= $this->title ?>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'lastname')->textInput() ?>

            <?= $form->field($model, 'firstname')->textInput() ?>
            <div class="form-group">
                <?= Html::submitButton('Đăng ký', ['class' => 'btn btn-primary pull-right', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
