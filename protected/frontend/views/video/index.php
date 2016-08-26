<?php
/* @var $this yii\web\View */

use yii\widgets\ListView;

$this->title = !empty($category) ? $category->name : 'Videoclip24h - Video, funny, tutorial online, download youtube mp4';
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag([
    'property' => 'og:title',
    'content' => $this->title
]);
$this->registerMetaTag([
    'property' => 'og:description',
    'content' => $this->title
]);
$this->registerMetaTag([
    'property' => 'og:keywords',
    'content' => 'Video funny, funny video, angular js, angular, yii2 framework, yii2 api, yii2, angular yii2, download youtube, download mp4, convert youtube to mp4'
]);
$this->registerMetaTag([
    'property' => 'og:url',
    'content' => 'http://videoclip24h.net'
]);
?>

<div class="panel panel-default panel-video">
    <div class="panel-body">
        <?=
        ListView::widget([
            'dataProvider' => $dataProvider,
            'options' => [
                'tag' => 'div',
                'class' => 'list-wrapper',
                'id' => 'list-wrapper',
            ],
            'layout' => "{items}\n<div class='col-sm-12 text-center'>{pager}</div>",
            'itemView' => '_item',
        ]);
        ?>
    </div>
</div>
