<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cấu hình';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">Cấu hình
                <button type="submit" class="btn btn-success pull-right">Cập nhật</button>
            </div>
            <div class="panel-body">

                <?php
                if (!empty($model)) {
                    foreach ($model as $value) {
                        ?>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="<?= $value->key ?>" class="control-label"><?= $value->description ?></label>

                                <?php
                                if ($value->type == 'textInput') {
                                    ?>
                                    <input name="value[<?= $value->key ?>]" type="text" class="form-control" id="<?= $value->key ?>" value="<?= $value->value ?>">
                                    <?php
                                } else {
                                    ?>
                                    <textarea name="value[<?= $value->key ?>]" class="form-control" id="<?= $value->key ?>" ><?= $value->value ?></textarea>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>


            </div>
        </div>
    </div>

</div>
<?php ActiveForm::end(); ?>