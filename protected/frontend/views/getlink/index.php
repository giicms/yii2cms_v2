<?php
/* @var $this yii\web\View */

use yii\widgets\ListView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Convert youtube to mp4';
?>


<?php $form = ActiveForm::begin(); ?>
<div class="panel panel-default">
    <div class="panel-heading"><?= $this->title ?>
<?= Html::submitButton('Getlink', ['class' => 'btn btn-primary pull-right']) ?>
    </div>
    <div class="panel-body">
        <?= $form->field($model, 'url')->textInput(['placeholder' => 'https://www.youtube.com/watch?v=eMSTp7Iz7Ns']) ?>
        <?php
        if (!empty($info)) {
            $i=1;
            foreach ($info['data'] as $key => $value) {
                parse_str($value, $item);
                echo '<p>'.$i.'. '. $item['type'] . ' <a class="btn btn-primary" href="' . $item['url'] . '?title=' . $info['title'] . '"> Dowload</a><br> <textarea style="height:200px" class="form-control">'.$item['url'].'</textarea><p>';
                     $i++;
            }
       
        }
        ?>
       
    </div>
</div>
<?php ActiveForm::end(); ?>