<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\AuthItem */
/* @var $context mdm\admin\components\ItemController */

$this->title =  $user->firstname . ' ' . $user->lastname;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Cập nhật';
?>
<?php $form = ActiveForm::begin(['id' => 'signup-form']); ?>
<div class="panel panel-default">
    <div class="panel-heading"><?= $this->title ?>
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
                    <?= $form->field($model, 'id')->hiddenInput(['value' => $user->id])->label(FALSE) ?>

                    <?= $form->field($model, 'username')->textInput(['value' => $user->username]) ?>

                    <?= $form->field($model, 'email')->textInput(['value' => $user->email]) ?>

                    <?= $form->field($model, 'firstname')->textInput(['value' => $user->firstname]) ?>

                    <?= $form->field($model, 'lastname')->textInput(['value' => $user->lastname]) ?>

                    <?= Html::submitButton('Cập nhật', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
                <div class="tab-pane" id="v-rules"> Phân quyền </div>
            </div>
        </div>

    </div>


</div>
<?php ActiveForm::end(); ?>