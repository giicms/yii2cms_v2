<?php
/* @var $this yii\web\View */

use common\widgets\CounterWidget;

$this->title = 'CMS Yii2';
?>

<!-- top tiles -->

<div class="row">
    <div class="col-sm-12">

        <h4 class="page-title">Xin chào !</h4>
    </div>
</div>


<!-- Start Widget -->
<div class="row">
    <div class="col-md-6 col-sm-6 col-lg-3">
        <div class="mini-stat clearfix bx-shadow bg-info">
            <span class="mini-stat-icon"><i class="ion-social-usd"></i></span>
            <div class="mini-stat-info text-right">
                <span class="counter">15852</span>
                Total Sales
            </div>
            <div class="tiles-progress">
                <div class="m-t-20">
                    <h5 class="text-uppercase text-white m-0">Last week's Sales <span class="pull-right">235</span></h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-3">
        <div class="mini-stat clearfix bg-purple bx-shadow">
            <span class="mini-stat-icon"><i class="ion-ios7-cart"></i></span>
            <div class="mini-stat-info text-right">
                <span class="counter">956</span>
                New Orders
            </div>
            <div class="tiles-progress">
                <div class="m-t-20">
                    <h5 class="text-uppercase text-white m-0">Last week's Orders <span class="pull-right">59</span></h5>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-6 col-lg-3">
        <div class="mini-stat clearfix bg-primary bx-shadow">
            <span class="mini-stat-icon"><i class="ion-android-contacts"></i></span>
            <div class="mini-stat-info text-right">
                <span class="counter">5210</span>
                New Users
            </div>
            <div class="tiles-progress">
                <div class="m-t-20">
                    <h5 class="text-uppercase text-white m-0">Last month's Users <span class="pull-right">136</span></h5>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-6 col-lg-3">
        <div class="mini-stat clearfix bg-success bx-shadow">
            <span class="mini-stat-icon"><i class="ion-eye"></i></span>
            <div class="mini-stat-info text-right">
                <span class="counter">20544</span>
                Unique Visitors
            </div>
            <div class="tiles-progress">
                <div class="m-t-20">
                    <h5 class="text-uppercase text-white m-0">Last month's Visitors <span class="pull-right">1026</span></h5>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- End row-->
<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Thống kê</h3>
            </div>
            <div class="panel-body">
                <canvas id="lineChart" data-type="Line" width="520" height="350"></canvas>
            </div>
        </div>
    </div>

</div>
<?= $this->registerCssFile('/admin/css/components.css',['depends' => [\yii\web\AssetBundle::className()]]) ?>
<?= $this->registerCssFile('/admin/css/jquery.nestable.css'); ?>
<?= $this->registerJsFile('/admin/js/jquery.nestable.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?= $this->registerJsFile('/admin/js/nestable.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?= $this->registerJsFile('/admin/js/chat.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?= $this->registerJsFile('/admin/js/chat.int.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>