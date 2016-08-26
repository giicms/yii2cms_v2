<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ManagerProduct */

$this->title = 'Create Manager Product';
$this->params['breadcrumbs'][] = ['label' => 'Manager Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manager-product-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
