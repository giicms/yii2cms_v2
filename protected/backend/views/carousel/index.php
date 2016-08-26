<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Menu;
use common\models\Product;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Carousel';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-sm-12">
        <div class="pull-right">


        </div>
        <h4></h4>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-default" style="margin-top: 20px">
            <div class="panel-heading">Carousel
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
                    'summary' => "<p>Hiển thị {begin} đến {end} trong tổng số {count} mục</p>",
                    'layout' => "{pager}\n{items}\n{summary}\n{pager}",
                    'columns' => [
                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'multiple' => true,
                        ],
                        ['class' => 'yii\grid\SerialColumn'],
                        'title',
                        [
                            'attribute' => 'created_at',
                            'format' => 'raw',
                            'value' => function($data) {
                                return date('d/m/Y', $data->created_at);
                            }
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
                            }
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
<input type="hidden" id="page" value="<?= !empty($_GET['page']) ? $_GET['page'] : 1 ?>">
<?= $this->registerJs('$("[name=status]").bootstrapSwitch({onText:"&nbsp;",offText:"&nbsp;",onColor:"default",offColor:"default"});') ?>
<?= $this->registerJs('
$("input[name=status]").on("switchChange.bootstrapSwitch", function(event, state) {
    var key = $(this).parent().parent().parent().parent("tr").attr("data-key");
        $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["carousel/status"]) . '", data: {id: key,state:state}, success: function (data) {
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
                url:"' . Yii::$app->urlManager->createUrl(["carousel/deletes"]) . '", data: {ids: keys,page:$("#page").val()}, success: function (data) {
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
        var page = $("#page").val();
      $.ajax({
                type: "POST",
                url:"' . Yii::$app->urlManager->createUrl(["carousel/status"]) . '", data: {ids: keys,page:page}, success: function (data) {
                },    
            });

    return false;
});

');
?>