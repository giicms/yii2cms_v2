<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\components;

use common\models\Menu;
use common\models\MenuItem;

class MenuHelper {

    public static function getMenu($name) {
        $menu = Menu::find()->where(['name' => $name])->one();
        $result = static::getMenuRecrusive($menu->id, 0);
        return $result;
    }

    private static function getMenuRecrusive($menu, $parent) {

        $items = MenuItem::find()->where(['menu_id' => $menu, 'parent_id' => $parent])->orderBy(['order' => SORT_ASC])->asArray()->all();
        $result = [];

        foreach ($items as $key => $item) {
            $result[] = [
                'label' => $item['type_name'],
                'url' => ($item['type'] == 'tree') ? '/category/' . $item['type_slug'] : '/' . $item['type_slug'],
                'items' => static::getMenuRecrusive($menu, $item['id'])
            ];
        }
        return $result;
    }

}
