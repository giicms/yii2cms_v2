<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\components\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\db\Query;
use common\models\Category;
use yii\widgets\Menu;

class CategoryWidget extends Widget {

    public function init() {
        
    }

    public function run() {
        $model = Category::find()->where(['publish' => Category::PUBLISH_ACTIVE])->all();
        ?>
        <div class="box">

            <div class="box-title"><h4>Category</h4></div>
            <ul class="list-inline list-cat">

                <?php
                foreach ($model as $value) {
                    ?>
                    <li><a title="<?= $value->title ?>" href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/category/' . $value->slug]) ?>"><?= $value->title ?></a></li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <?php
    }

}
