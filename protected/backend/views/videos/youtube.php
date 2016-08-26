<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\tree\TreeViewInput;

/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = 'Scrap du lieu';
$this->params['breadcrumbs'][] = ['label' => 'Video', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <?php $form = ActiveForm::begin(); ?>
    <div class="panel panel-default">
        <div class="panel-heading"><?= $this->title ?>
            <?= Html::submitButton('Lay du lieu', ['class' => 'btn btn-primary pull-right']) ?>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label class="control-label">Danh mục</label>
                <?php
                echo TreeViewInput::widget([
                    // single query fetch to render the tree
                    'query' => \common\models\Tree::find()->where(['type' => 'video'])->addOrderBy('root, lft'),
                    'headingOptions' => ['label' => 'Categories'],
                    'name' => 'category', // input name
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
            <?= $form->field($model, 'option')->dropDownList($model->options); ?> 

            <?= $form->field($model, 'channelId')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'total')->textInput(['maxlength' => true]) ?>



        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
