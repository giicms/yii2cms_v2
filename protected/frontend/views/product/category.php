<?php
/* @var $this yii\web\View */

use yii\widgets\ListView;

$this->title = !empty($category) ? $category->name : 'Apps Games';
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag([
    'name' => 'description',
    'content' => $category->description
]);
$this->registerLinkTag([
    'rel' => 'prev',
    'title' => $category->name,
    'link' => Yii::$app->urlManager->createAbsoluteUrl(['/category/' . $category->slug])
]);
$this->registerLinkTag([
    'rel' => 'canonical',
    'link' => Yii::$app->urlManager->createAbsoluteUrl(['/category/' . $category->slug])
]);
$this->registerLinkTag([
    'rel' => 'shortlink',
    'link' => Yii::$app->urlManager->createAbsoluteUrl(['/category/' . $category->slug])
]);
?>

<div class="site-index">
    <div class="body-content">
        <?=
        ListView::widget([
            'dataProvider' => $dataProvider,
            'options' => [
                'tag' => 'div',
                'class' => 'list-wrapper',
                'id' => 'list-wrapper',
            ],
            'layout' => "{items}\n{pager}",
            'itemView' => '_category',
        ]);
        ?>
    </div>
</div>
<?=
$this->registerJs("$(document).on('click', '.item-modal', function (event){
        event.preventDefault();
        var id = $(this).attr('data-id');
              $('#full-width-modal').modal({backdrop: 'static', keyboard: false});
    $.ajax({
        url: '/product/view/'+id,
            success: function(data) {
               $('body,html').css('overflow','hidden');
                    $('#full-width-modal').modal('show');
                    $('#full-width-modal').find('.modal-body').html(data);    
              
            }
        });

});");
?>
<?=
$this->registerJs("$(document).on('click', '.close-modal', function (event){
        event.preventDefault();
        $('body,html').css('overflow','auto');
                    $('#full-width-modal').modal('hide');

});");
?>
<div id="full-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="full-width-modalLabel" aria-hidden="true" style="display: none">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!--            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>-->
            <div class="modal-body">
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?= $this->registerJs('
$(".add").on("click", function(event, state) {
    var key = $(this).parent().parent().parent().parent().parent().parent("div").attr("data-key");
    var act = $(this).attr("data");
        $.ajax({
        type: "POST",
        url:"' . Yii::$app->urlManager->createUrl(["cart/add"]) . '",
             data: {id: key,act:act},
            success: function (data) {
                $(".quantity").text(data.quantity);
                $(".add_"+key).hide();
                $(".empty_"+key).show();
                if(data.total>0){
                $(".numcart span").text(data.total);
                } else {
                 $(".numcart span").text("");
                }
            }, 
        });
});
') ?>

<?= $this->registerJs('
$(".addto").on("click", function(event, state) {
    var key = $(this).parent().parent().parent().parent().parent().parent().parent("div").attr("data-key");
    var act = $(this).attr("data");
        $.ajax({
        type: "POST",
        url:"' . Yii::$app->urlManager->createUrl(["cart/add"]) . '",
             data: {id: key,act:act},
            success: function (data) {
               if(data.total>0){
                $(".numcart span").text(data.total);
                } else {
                 $(".numcart span").text("");
                }
            if(data.quantity > 0){
            $(".empty_"+key+" .quantity").text(data.quantity);
            } else {
                $(".add_"+key).show();
                $(".empty_"+key).hide();
            }
            }, 
        });
});
') ?>

