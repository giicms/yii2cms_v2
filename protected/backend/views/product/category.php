
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use common\models\Category;
use kartik\tree\TreeView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Danh mục';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-default">

            <div class="panel-body">
                <?php
                echo TreeView::widget([
                    // single query fetch to render the tree
                    'query' => \common\models\Tree::find()->where(['type'=>'product'])->addOrderBy('root, lft'),
                    'nodeAddlViews' => ['type'=>'product'],
                    'headingOptions' => ['label' => 'Danh mục'],
                    'isAdmin' => false, // optional (toggle to enable admin mode)
                    'displayValue' => 1, // initial display value
                        //'softDelete'      => true,                        // normally not needed to change
                        //'cacheSettings'   => ['enableCache' => true]      // normally not needed to change
                ]);
                ?>
            </div>
        </div>
    </div>
</div>
