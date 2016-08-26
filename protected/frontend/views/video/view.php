<?php

use yii\widgets\ListView;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = $model->title;

$this->registerMetaTag([
    'property' => 'og:title',
    'content' => $model->title
]);
$this->registerMetaTag([
    'property' => 'og:image',
    'content' => $model->image
]);
$this->registerMetaTag([
    'property' => 'og:description',
    'content' => $this->title
]);
$this->registerMetaTag([
    'property' => 'og:keywords',
    'content' => 'Video funny, funny video, angular js, angular, yii2 framework, yii2 api, yii2, angular yii2'
]);
$this->registerLinkTag([
    'rel' => 'prev',
    'title' => $model->title,
    'link' => Yii::$app->urlManager->createAbsoluteUrl(['/video/' . $model->slug])
]);
$this->registerLinkTag([
    'rel' => 'canonical',
    'link' => Yii::$app->urlManager->createAbsoluteUrl(['/video/' . $model->slug])
]);
$this->registerLinkTag([
    'rel' => 'shortlink',
    'link' => Yii::$app->urlManager->createAbsoluteUrl(['/' . $model->slug])
]);
$this->registerLinkTag([
    'property' => 'og:url',
    'link' => Yii::$app->urlManager->createAbsoluteUrl(['/' . $model->slug])
]);

frontend\components\widgets\ViewWidget::widget(['id' => $model->id]);
?>
<div class="row">
    <div class="col-sm-8">
        <div class="panel panel-default panel-video">
            <div class="panel-body" style="padding: 15px">
                <!--                <video controls="controls" style="width:100%" poster="" autoplay
                                       class="video-stream" 
                                       x-webkit-airplay="allow" 
                                       data-youtube-id="N9oxmRT2YWw" 
                                       src=''></video>-->
                <?= $model->url ?>
                <h2><?= $model->title ?></h2>
                <p>
                    <?= !empty($model->count) ? $model->count : 0 ?> lượt xem
                    <?php if ($model->type == 'facebook') {
                        ?>
                        <a class="pull-right btn btn-primary" target="blank" href="<?= $model->file ?>">Download</a>
                        <?php
                    } else {
                        ?>
                        <a class="pull-right btn btn-primary" target="blank" href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/getlink/view?v=' . $model->video_id]) ?>">Download</a>
                    <?php } ?>
                </p>
            </div>

        </div>

        <div class="panel panel-default panel-video">
            <div class="panel-heading">
                <h3 class="panel-title">NHẬN XÉT </h3>
            </div>
            <div class="panel-body">
                <div class="comments">
                    <div class="fb-comments" data-href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/video/' . $model->slug]) ?>" data-colorscheme="light" data-numposts="10" data-width="100%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="panel panel-default panel-video">
            <div class="panel-body panel-body-list">
                <?=
                ListView::widget([
                    'dataProvider' => $dataProvider,
                    'options' => [
                        'tag' => 'div',
                        'class' => 'list-wrapper',
                        'id' => 'list-wrapper',
                    ],
                    'layout' => "{items}",
                    'itemView' => '_list',
                ]);
                ?>
            </div>
        </div>
    </div>
</div>
<?= $this->registerCssFile('/themes/shop/css/components.css', ['depends' => [\yii\web\AssetBundle::className()]]) ?>