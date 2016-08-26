<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Menu;

/* @var $this yii\web\View */
/* @var $searchModel app\models\searchs\Option */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Options';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading"> Danh sách
                <div class="pull-right">

                    <?php
                    echo Menu::widget([
                        'items' => [

                            ['label' => 'Tùy chỉnh',
                                'url' => 'javascript:void(0)',
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
                    'id' => 'girdOption',
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
                        'key',
                        'title',
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => function($data) {
                                if ($data['status'] == \common\models\Option::PUBLISH_ACTIVE)
                                    $check = 'checked';
                                else
                                    $check = '';
                                return '<input type="checkbox" name="status" ' . $check . '>';
                            },
                            'filter' => [\common\models\Option::PUBLISH_ACTIVE => "Publish", \common\models\Option::PUBLISH_NOACTIVE => "Private"]
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
        $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["option/status"]) . '", data: {id: key,state:state}, success: function (data) {
            }, });
});
') ?>
<?= $this->registerJs('
    $(".delete").click(function () {
    var keys = $("#girdOption").yiiGridView("getSelectedRows");
        if(keys==""){
        var msg = confirm("Bạn chưa chọn mục tin nào");
        } else {
            var msg = confirm("Bạn có chắc chắn muốn mở các mẫu tin này không (s)");
        };
     
    if (msg == true) {
     if(keys!=""){
      $.ajax({
                type: "POST",
                url:"' . Yii::$app->urlManager->createUrl(["option/deletes"]) . '", data: {ids: keys}, success: function (data) {
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
        var keys = $("#girdOption").yiiGridView("getSelectedRows");
      $.ajax({
                type: "POST",
                url:"' . Yii::$app->urlManager->createUrl(["option/status"]) . '", data: {ids: keys}, success: function (data) {
                    if(data=="ok"){
                        window.location.href = "' . $_SERVER['REQUEST_URI'] . '";        
                    }
                },    
            });

    return false;
});

');
?>