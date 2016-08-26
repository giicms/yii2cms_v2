<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\models;

use Yii;

class Tree extends \kartik\tree\models\Tree {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tree';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name'], 'required', 'message' => '{attribute} không được rỗng.'],
            [['description', 'slug'], 'string'],
            [['keywords', 'icon'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 20]
        ];
    }

}
