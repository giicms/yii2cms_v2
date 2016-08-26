<?php
/* @var $this yii\web\View */

use yii\widgets\ListView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\tree\TreeViewInput;

$this->title = 'Download video facebook';
?>


<?php $form = ActiveForm::begin(); ?>
<div class="panel panel-default">
    <div class="panel-heading"><?= $this->title ?>
        <?= Html::submitButton('Getlink', ['class' => 'btn btn-primary pull-right']) ?>
    </div>
    <div class="panel-body">
        <div>
            <?= 'Vi du link: https://www.facebook.com/funbabyvideos/?fref=ts';
            ?>
        </div>
        <?= $form->field($model, 'fid')->textInput(['placeholder' => 'funbabyvideos']) ?>
        <?= $form->field($model, 'limit')->textInput(['placeholder' => 'So video']) ?>
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
        <?php
        if (!empty($videos)) {
            $i = 1;
            foreach ($videos as $key => $value) {
                ?>
                <div class="media">
                    <div class="media-left">
                        <a href="#">
                            <img class="media-object" style="width: 120px" src="<?= $value['picture'] ?>">
                        </a>
                    </div>
                    <div class="media-body">
                        <p><?= $value['description'] ?></p>
                        <a target="bank" href="<?= $value['source'] ?>">Download</a>
                        <p><textarea class="form-control"><?= $value['source'] ?></textarea></p>
                    </div>
                </div>
                <?php
            }
        }
        ?>

    </div>
</div>
<?php ActiveForm::end(); ?>