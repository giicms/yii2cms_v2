<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/sweetalert.css',
        'css/core.css',
        'css/icons.css',
        'css/summernote.css',
        'css/pages.css',
        'css/menu.css',
        'css/responsive.css',
        'css/select2.min.css',
        'css/bootstrap-switch.min.css'
    ];
    public $js = [
        'js/modernizr.min.js',
        'js/select2.min.js',
        'js/detect.js',
        'js/wysihtml5-0.3.0.js',
        'js/bootstrap-wysihtml5.js',
        'js/summernote.min.js',
        'js/jquery.uploadfile.min.js',
        'js/bootstrap-switch.min.js',
        'js/jquery.nicescroll.js',
          'js/jquery.app.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
