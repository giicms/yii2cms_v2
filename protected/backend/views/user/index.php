<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Menu;
use common\models\Post;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
$page = '123';
?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">Danh sách
                <div class="pull-right">
                    <?php
                    echo Menu::widget([
                        'items' => [

//                            ['label' => 'Tùy chỉnh',
//                                'url' => ['page/index'],
//                                'options' => ['class' => 'dropdown'],
//                                'template' => '<a href="{url}"  class="dropdown-toggle btn btn-primary" data-toggle="dropdown" aria-expanded="true">{label}</a>',
//                                'items' => [
//                                    ['label' => 'Xóa', 'url' => 'javascript:void(0)', 'options' => ['class' => 'delete']],
////                                    ['label' => 'Cập nhập trạng thái', 'url' => 'javascript:void(0)', 'options' => ['class' => 'status']],
//                                ]
//                            ],
                            ['label' => 'Thêm mới', 'template' => '<a href="{url}" class="btn btn-success">{label}</a>', 'url' => [ 'create']],
                        ],
                        'submenuTemplate' => "\n<ul class='dropdown-menu' role='menu'>\n{items}\n</ul>\n",
                        'options' => [ 'class' => 'nav navbar-nav'],
                        'encodeLabels' => false,
                    ]);
                    ?>
                </div>
            </div>
            <div class="panel-body">
                <?=
                GridView::widget([
                    'id' => 'girdUser',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'summary' => "<p>Hiển thị {begin} đến {end} trong tổng số {count} mục</p>",
                    'layout' => "{items}\n{summary}\n{pager}",
                    'columns' => [
                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'multiple' => true,
                        ],
                        ['class' => 'yii\grid\SerialColumn'],
                        'firstname',
                        'lastname',
                        'username',
                        'email',
                        'role',
                        ['class' => 'backend\components\columns\ActionColumn',
                            'template' => '{update} {delete}'
                        ],
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
</div>
<?= $this->registerJs('$("[name=status]").bootstrapSwitch({onText:"&nbsp;",offText:"&nbsp;",onColor:"default",offColor:"default"});') ?>
<?= $this->registerJs('
$("input[name=status]").on("switchChange.bootstrapSwitch", function(event, state) {
    var key = $(this).parent().parent().parent().parent("tr").attr("data-key");
        $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["category/publish"]) . '", data: {id: key,state:state}, success: function (data) {
            }, });
});
') ?>