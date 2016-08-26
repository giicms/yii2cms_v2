<?php
/* @var $this yii\web\View */

use yii\widgets\ListView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Download facebook';
?>


<?php $form = ActiveForm::begin(); ?>
<div class="panel panel-default">
    <div class="panel-heading"><?= $this->title ?>
<?= Html::submitButton('Getlink', ['class' => 'btn btn-primary pull-right']) ?>
    </div>
    <div class="panel-body">
        <?= $form->field($model, 'fid')->textInput(['placeholder' => 'User, Page, Post, Event']) ?>

    </div>
</div>
<?php ActiveForm::end(); ?>