<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Option */

$this->title = 'Cập nhập: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tùy chỉnh', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
