<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\searchs\ManagerProduct */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Xuất nhập kho';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">Danh sách
                <div class="pull-right">

                    <?php
                    echo yii\widgets\Menu::widget([
                        'items' => [

                            ['label' => 'Tùy chỉnh',
                                'url' => ['page/index'],
                                'options' => ['class' => 'dropdown'],
                                'template' => '<a href="{url}"  class="dropdown-toggle btn btn-primary" data-toggle="dropdown" aria-expanded="true">{label}</a>',
                                'items' => [
                                    ['label' => 'Xóa', 'url' => 'javascript:void(0)', 'options' => ['class' => 'delete']]
                                ]
                            ]
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
                    'layout' => "{items}\n{summary}\n{pager}",
                    'columns' => [
                          [
                            'class' => 'yii\grid\CheckboxColumn',
                            'multiple' => true,
                        ],
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'product_id',
                            'format' => 'html',
                            'value' => function($data) {
                                return $data->product->title;
                            },
                        ],
                        'number',
                        [
                            'attribute' => 'user_id',
                            'format' => 'html',
                            'value' => function($data) {
                                return $data->user->lastname . ' ' . $data->user->firstname;
                            },
                        ],
                        [
                            'attribute' => 'date',
                            'format' => 'html',
                            'value' => function($data) {
                                return date('d/m/Y', $data->created_at);
                            },
                            'filter' => \yii\jui\DatePicker::widget(['dateFormat' => 'dd/MM/yyyy',
                                'model' => $searchModel,
                                'attribute' => 'date'
                            ]),
                        ],
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => function($data) {
                                if ($data['status'] == \common\models\ManagerProduct::STATUS_EXPORT)
                                    $check = 'Xuất kho';
                                else
                                    $check = 'Nhập kho';
                                return $check;
                            },
                            'filter' => [\common\models\ManagerProduct::STATUS_EXPORT => "Xuất kho", \common\models\ManagerProduct::STATUS_IMPORT => "Nhập kho"]
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
                url:"' . Yii::$app->urlManager->createUrl(["managerproduct/deletes"]) . '", data: {ids: keys,page:$("#page").val()}, success: function (data) {
                },    
            });
         }
    }
    return false;
});

');
?>
