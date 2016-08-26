<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Option */

$this->title = 'Thêm mới';
$this->params['breadcrumbs'][] = ['label' => 'Tùy chỉnh', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
