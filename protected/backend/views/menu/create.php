<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = 'Thêm mới';
$this->params['breadcrumbs'][] = ['label' => 'Menu', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-sm-4">

        <div class="panel panel-default">
            <div class="panel-heading">
                Mục lục 
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
                Thêm mới
            </div>
            <div class="panel-body">
                <?=
                $this->render('_form', [
                    'model' => $model,
                ])
                ?>
            </div>
        </div>
    </div>
</div>
