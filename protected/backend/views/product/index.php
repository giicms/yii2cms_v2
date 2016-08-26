<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Menu;
use common\models\Product;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sản phẩm';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">Danh sách
                <div class="pull-right">
                    <?php
                    echo Menu::widget([
                        'items' => [

                            ['label' => 'Tùy chỉnh',
                                'url' => ['page/index'],
                                'options' => ['class' => 'dropdown'],
                                'template' => '<a href="{url}"  class="dropdown-toggle btn btn-primary" data-toggle="dropdown" aria-expanded="true">{label}</a>',
                                'items' => [
                                    ['label' => 'Xóa', 'url' => 'javascript:void(0)', 'options' => ['class' => 'delete']],
                                    ['label' => 'Cập nhập trạng thái', 'url' => 'javascript:void(0)', 'options' => ['class' => 'status']],
                                ]
                            ],
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
                    'id' => 'girdProduct',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'summary' => "<p>Hiển thị {begin} đến {end} trong tổng số {count} mục</p>",
                    'layout' => "{pager}\n{items}\n{summary}\n{pager}",
                    'columns' => [
                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'multiple' => true,
                        ],
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'category_id',
                            'format' => 'raw',
                            'value' => function($data) {
                                $rs = [];
                                foreach ($data->tree as $value) {
                                    $rs[] = $value['name'];
                                }
                                return implode(',', $rs);
                            },
                                    'filter' => yii\helpers\ArrayHelper::map(\common\models\Tree::find()->addOrderBy('root, lft')->all(), 'id', 'name')
                                ],
                                'title',
                                [
                                    'attribute' => 'price',
                                    'format' => 'raw',
                                    'value' => function($data) {
                                        return number_format($data->price, 0);
                                    },
                                    'filter' => ['0,100000' => 'Dưới 100.000',
                                        '100000,200000' => 'Từ 100.000 đến 200.000',
                                        '200000,300000' => 'Từ 200.000 đến 300.000',
                                        '300000,400000' => 'Từ 300.000 đến 400.000',
                                        '400000,500000' => 'Từ 400.000 đến 500.000',
                                        '500000,1000000' => 'Trên 500.000'
                                    ],
                                ],
                                [
                                    'attribute' => 'created_at',
                                    'format' => 'html',
                                    'value' => function($data) {
                                        return date('d/m/Y', $data->created_at);
                                    },
                                    'filter' => \yii\jui\DatePicker::widget(['dateFormat' => 'dd/MM/yyyy',
                                        'model' => $searchModel,
                                        'attribute' => 'created_at'
                                    ]),
                                ],
                                [
                                    'attribute' => 'status',
                                    'format' => 'raw',
                                    'value' => function($data) {
                                        if ($data['status'] == Product::PUBLISH_ACTIVE)
                                            $check = 'checked';
                                        else
                                            $check = '';
                                        return '<input type="checkbox" name="status" ' . $check . '>';
                                    },
                                    'filter' => [\common\models\Option::PUBLISH_ACTIVE => "Publish", \common\models\Option::PUBLISH_NOACTIVE => "Private"]
                                ],
                                [
                                    'attribute' => 'Xuất, nhập kho',
                                    'format' => 'raw',
                                    'value' => function($data) {
                                        return '<a href="javascript:void(0)" class="add" data="' . $data->id . '">Thêm</a>';
                                    },
                                ],
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
        $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["product/status"]) . '", data: {id: key,state:state}, success: function (data) {
            }, });
});
') ?>
        <?= $this->registerJs('
    $(".delete").click(function () {
    var keys = $("#girdProduct").yiiGridView("getSelectedRows");
        if(keys==""){
        var msg = confirm("Bạn chưa chọn mục tin nào");
        } else {
            var msg = confirm("Bạn có chắc chắn muốn mở các mẫu tin này không (s)");
        };
     
    if (msg == true) {
     if(keys!=""){
      $.ajax({
                type: "POST",
                url:"' . Yii::$app->urlManager->createUrl(["product/deletes"]) . '", data: {ids: keys}, success: function (data) {
                },    
            });
         }
    }
    return false;
});

');
        ?>

        <?= $this->registerJs('
    $(".status").click(function () {
        var keys = $("#girdProduct").yiiGridView("getSelectedRows");
      $.ajax({
                type: "POST",
                url:"' . Yii::$app->urlManager->createUrl(["product/status"]) . '", data: {ids: keys}, success: function (data) {
                    if(data=="ok"){
                        window.location.href = "' . $_SERVER['REQUEST_URI'] . '";        
                    }
                },    
            });

    return false;
});

');
        ?>
        <div class="modal fade bs-example-modal-sm" id="modal" tabindex="-1" role="dialog">    
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Xuất nhập kho</h4>
                    </div>
                    <div class="modal-body">

                    </div>
                </div>
            </div>
        </div>    
        <?=
        $this->registerJs("$(document).on('click', '.add', function (event){
        event.preventDefault();
        var id = $(this).attr('data');
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["ajax/managerproduct"]) . "',
            type: 'post',
            data: {id:id},
            success: function(data) {
                    $('#modal').modal('show');
                    $('#modal').find('.modal-body').html(data);                                
            }
        });

});");
        ?>