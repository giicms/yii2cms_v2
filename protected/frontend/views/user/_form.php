<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
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
                    <?= $form->field($model, 'username') ?>

                    <?= $form->field($model, 'email') ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>

                    <?= $form->field($model, 'firstname') ?>

                    <?= $form->field($model, 'lastname') ?>
                    

                </div>
                <div class="tab-pane" id="v-rules"> Phân quyền </div>
            </div> 
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>