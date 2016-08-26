<?php
/* @var $this yii\web\View */

use yii\widgets\ListView;

$this->title = $key;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-index">
    <div class="body-content">
        <?=
        ListView::widget([
            'dataProvider' => $dataProvider,
            'options' => [
                'tag' => 'div',
                'class' => 'list-wrapper',
                'id' => 'list-wrapper',
            ],
            'layout' => "{items}\n{pager}",
            'itemView' => '/post/_item',
        ]);
        ?>
    </div>
</div>
