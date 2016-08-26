<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use Yii;
use yii\web\AssetBundle;

Yii::setAlias('@themes', Yii::$app->view->theme->baseUrl);

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@themes';
    public $css = [
        'css/core.css',
        'css/video.css',
        'css/icons.css',
        'css/pages.css',
        'css/menu.css',
        'css/responsive.css',
    ];
    public $js = [
        'js/modernizr.min.js',
        'js/detect.js',
        'js/jquery.uploadfile.min.js',
        'js/jquery.nicescroll.js',
        'js/jquery.app.js',
        'js/jquery.swfobject.js',
        'js/jquery.jwplayer.js'
    ];
    public $depends = [
            'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    
    ];

}
