<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\components\widgets;

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use common\models\Menu;
use common\models\MenuItem;
use yii\helpers\Url;

class MenuWidget extends Widget {

    public $name;

    public function init() {
        
    }

    public function run() {

        $menu = Menu::find()->where(['name' => $name])->one();
        $item = MenuItem::find()->where(['menu_id' => $menu->id])->orderBy(['parent_id' => SORT_DESC])->all();
        NavBar::begin();
        $menuItems = [
            ['label' => 'Home', 'url' => ['/site/index']],
        ];
        foreach ($item as $value) {
            if ($value->type == "tree") {
                $url = Url::to(['/category/' . $value->type_slug]);
            } else {
                $url = Url::to(['/' . $value->type_slug]);
            }
            $menuItems[] = ['label' => $value->type_name, 'url' => $url];
        }
        $menuItems[] = ['label' => 'Contact', 'url' => ['/site/contact']];
        echo Nav::widget([
            'options' => ['class' => 'navigation-menu'],
            'items' => $menuItems,
        ]);
        NavBar::end();
    }

}


