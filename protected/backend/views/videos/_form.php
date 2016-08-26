<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\tree\TreeViewInput;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>
<div class="panel panel-default">
    <div class="panel-heading"><?= $this->title ?>
        <?= Html::submitButton('Lưu', ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>
    </div>
    <div class="panel-body">
        <div class="tabs-vertical-env">
            <ul class="nav tabs-vertical">
                <li class="active"><a href="#v-home" data-toggle="tab" aria-expanded="false">Tổng quan</a></li>
                <li><a href="#v-seo" data-toggle="tab" aria-expanded="false">Seo</a></li>

            </ul>
            <div class="tab-content">

                <div class="tab-pane active" id="v-home"> 
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                    <div class="form-group">
                        <label class="control-label">Danh mục</label>
                        <?php
                        echo TreeViewInput::widget([
                            // single query fetch to render the tree
                            'query' => \common\models\Tree::find()->where(['type' => 'video'])->addOrderBy('root, lft'),
                            'headingOptions' => ['label' => 'Categories'],
                            'name' => 'category', // input name
                            'value' => $model->category_id, // values selected (comma separated for multiple select)
                            'asDropdown' => true, // will render the tree input widget as a dropdown.
                            'multiple' => FALSE, // set to false if you do not need multiple selection
                            'fontAwesome' => true, // render font awesome icons
                            'rootOptions' => [
                                'label' => '<i class="fa fa-tree"></i>',
                                'class' => 'text-success'
                            ], // custom root label
                                //'options'         => ['disabled' => true],
                        ]);
                        ?>


                    </div>
                    <?= $form->field($model, 'url')->textarea() ?>


                    <?= $form->field($model, 'tags')->dropDownList($model->tags, ['multiple' => TRUE]); ?>


                </div>
                <div class="tab-pane" id="v-seo"> 
                    <?= $form->field($model, 'keywords')->textInput() ?>
                    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
                </div>
            </div>
        </div> 
    </div>
</div>
<?php ActiveForm::end(); ?>
<?=
$this->registerJs('
$("#video-tags").select2({
  tags: true,
  tokenSeparators: [","]
});

');
?>
