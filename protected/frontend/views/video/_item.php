<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="col-sm-5th col-sm-5">
    <div class="box">
        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/video/' . $model->slug]) ?>" title="<?= $model->title ?>">
            <img style="width:227px; height: 165px" src="<?= $model->image ?>" alt="<?= $model->title ?>">
        </a>
        <h5 class="title"><a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/video/' . $model->slug]) ?>" title="<?= $model->title ?>"><?= Yii::$app->convert->excerpt($model->title, 45) ?><small>(<?=$model->type?>)</small></a></h5>
        <p><small><?= !empty($model->count) ? $model->count : 0 ?> lượt view 
                <?php if ($model->type == 'facebook') {
                    ?>
                    <a class="pull-right" target="blank" href="<?= $model->file ?>">Download</a>
                    <?php
                } else {
                    ?>
                    <a class="pull-right" target="blank" href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/getlink/view?v=' . $model->video_id]) ?>">Download</a>
                <?php } ?>
                    </small>
        </p>
    </div>
</div>