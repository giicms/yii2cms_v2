<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="media-item">
    <div class="media">
        <div class="media-left">
            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/video/' . $model->slug]) ?>">
                <img class="media-object" src="<?= $model->image ?>" alt="<?= $model->title ?>" width="120">
            </a>
        </div>
        <div class="media-body">
            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/video/' . $model->slug]) ?>"><h4 class="media-heading"><?= $model->title ?></h4></a>
            <small><?= !empty($model->count) ? $model->count : 0 ?> lượt xem</small>
            <p>   <?php if ($model->type == 'facebook') {
    ?>
                    <a target="blank" href="<?= $model->file ?>">Download</a>
                    <?php
                } else {
                    ?>
                    <a target="blank" href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/getlink/view?v=' . $model->video_id]) ?>">Download</a>
                <?php } ?></p>
        </div>
    </div>
</div>