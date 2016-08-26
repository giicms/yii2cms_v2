
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Menu;
use common\models\Post;
use common\models\Category;
use common\models\MenuItem;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Menu', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$tree = \common\models\Tree::find()->where(['active' => 1])->addOrderBy('root, lft')->all();
?>
<?php $form = ActiveForm::begin(['id' => 'formMenu']); ?>
<?= $form->field($model, 'id')->hiddenInput()->label(FALSE) ?>
<div class="row">
    <div class="col-sm-4">

        <div class="panel panel-default">
            <div class="panel-heading">
                Mục lục 
                <?= Html::submitButton('Add', ['class' => 'btn btn-primary pull-right', 'name' => 'add']) ?>

            </div>
            <div class="panel-body">
                <ul class="nav nicescroll" style="height: 200px">

                    <?php
                    if (!empty($tree)) {
                        foreach ($tree as $value) {
                            ?>
                            <li>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="tree[]" value="<?= $value['id'] ?>">
                                        <?= $value['name'] ?>
                                    </label>
                                </div>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Page
                <?= Html::submitButton('Add', ['class' => 'btn btn-primary pull-right', 'name' => 'add']) ?>

            </div>
            <div class="panel-body">
                <ul class="nav nicescroll" style="height: 200px">
                    <?php
                    if (!empty($page)) {
                        foreach ($page as $value) {
                            ?>
                            <li>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="page[]" value="<?= $value['id'] ?>">
                                        <?= $value['title'] ?>
                                    </label>
                                </div>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="form-group" style="float:left; margin-right: 10px">
                    <input type="text" class="form-control" name="menu-name" value="<?= $model->name ?>">
                </div>
                <div style="float:left; margin-top: -2px; margin-right: 5px">
                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <?= $model->name ?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <?php
                            if (!empty($menuall)) {
                                foreach ($menuall as $value) {
                                    ?>
                                    <li><a href="<?= Yii::$app->urlManager->createUrl(["menu/view", 'id' => $value->id]) ?>"><?= $value->name ?></a></li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div> hoặc <a href="<?= Yii::$app->urlManager->createUrl(["menu/create"]) ?>"> Tạo mới</a>
                <?= ($model->active == 1) ? Html::submitButton('Xóa', ['class' => 'btn btn-danger pull-right', 'name' => 'delete']) : "" ?>
            </div>
            <div class="panel-body">
                <div class="dd" id="nestable_list_2">

                    <?php

                    function menu($id, &$data = [], $parent = 0) {
                        $category = MenuItem::find()->where(['parent_id' => $parent, 'menu_id' => $id])->orderBy(['order' => SORT_ASC])->all();
                        if (!empty($category)) {
                            echo'<ol class="dd-list" id=' . $parent . '>';
                            foreach ($category as $key => $value) {
                                ?>
                                <li class="dd-item dd-item-<?= $value->id ?>" data-id="<?= $value->id ?>" style="position: relative">
                                    <input type="hidden" value="<?= $value->id ?>">
                                    <div class="dd-handle"><?= $value->type_name ?>
                                    </div>
                                    <small style=" position: absolute; top: 10px; right: 10px"><a href="<?= Yii::$app->urlManager->createUrl(["menu/deleteitem", 'id' => $value->id]) ?>" class="dd-item-delete">Xóa</a></small>
                                    <?= menu($id, $data, $value->id); ?>
                                </li>
                                <?php
                            }
                            echo '</ol>';
                        }
                    }

                    echo menu($model->id);
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?= $this->registerCssFile('/admin/css/jquery.nestable.css'); ?>
<?= $this->registerJsFile('/admin/js/jquery.nestable.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?= $this->registerJsFile('/admin/js/nestable.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?= $this->registerJs('
    $(".dd-item-delete").click(function () {
        var id = $(this).parent().parent()..parent("tr").attr("data-id");
      $.ajax({
                type: "POST",
                url:"' . Yii::$app->urlManager->createUrl(["menu/deleteitem"]) . '", data: {id: id}, success: function (data) {
                    if(data=="ok"){
                        window.location.href = "' . $_SERVER['REQUEST_URI'] . '";        
                    }
                },    
            });

    return false;
});

');
?>