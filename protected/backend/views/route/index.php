<?php

use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\YiiAsset;

/* @var $this yii\web\View */
$this->title = 'Routes';
$this->params['breadcrumbs'][] = $this->title;


$opts = Json::htmlEncode([
            'newUrl' => Url::to(['create']),
            'assignUrl' => Url::to(['assign']),
            'refreshUrl' => Url::to(['refresh']),
            'routes' => $routes
        ]);
$this->registerJs("var _opts = {$opts};");
$this->registerJs($this->render('_script.js'));
?>
<div class="panel panel-default">
    <div class="panel-heading"><?= $this->title ?>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="input-group">
                    <input id="inp-route" type="text" class="form-control"
                           placeholder="<?= 'New route(s)' ?>">
                    <span class="input-group-btn">
                        <button id="btn-new" class="btn btn-success" name="add-route">
                            Add
                            <i class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>
        <p>&nbsp;</p>
        <div class="row">
            <div class="col-sm-5">
                <input class="form-control search" data-target="avaliable"
                       placeholder="Search">

                <select multiple size="20" class="form-control list" data-target="avaliable">
                </select>
            </div>
            <div class="col-sm-2" style="text-align: center">
                <br><br>
                <a href="#" class="btn btn-success btn-assign" data-action="assign">&gt;&gt;
                    <i class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>
                </a><br>
                <a href="#" class="btn btn-danger btn-assign" data-action="remove">&lt;&lt;
                    <i class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i></a>
            </div>
            <div class="col-sm-5">
                <input class="form-control search" data-target="assigned"
                       placeholder="Tim kiem">
                <select multiple size="20" class="form-control list" data-target="assigned">
                </select>
            </div>
        </div>
    </div>
</div>