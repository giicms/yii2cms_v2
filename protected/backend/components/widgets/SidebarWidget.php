<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\components\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\db\Query;
use yii\widgets\Menu;
use common\models\Type;

class SidebarWidget extends Widget {

    public function init() {
        
    }

    public function run() {
        ?>

        <div class="navbar-custom">
            <div class="container">
                <div id="navigation">
                    <!-- Navigation Menu-->
                    <?php
                    $items[] = ['label' => '<i class="fa fa-dashboard"></i> <span>Dashboard</span>', 'url' => ['/site/index']];
                    $items[] = ['label' => '<span>Doanh số bán hàng</span>', 'url' => 'javascript:void(0)', 'items' => [
                            ['label' => 'Đơn hàng', 'url' => ['/order']],
                        ],
                    ];
                    $items[] = ['label' => '<span>Mục lục</span>', 'url' => 'javascript:void(0)', 'items' => [
                            ['label' => 'Quản lý danh mục', 'url' => ['/product/category']],
                            ['label' => 'Quản lý sản phẩm', 'url' => ['/product']],
                            ['label' => 'Xuất nhập kho', 'url' => ['/managerproduct']],
                        ],
                    ];
                    $items[] = ['label' => 'Widgets', 'url' => '#', 'items' => [
                            ['label' => 'Menu', 'url' => ['/menu']],
                            ['label' => 'Carousel', 'url' => ['/carousel']],
                            ['label' => 'Tùy chỉnh', 'url' => ['/option']],
                            ['label' => 'Blog', 'url' => ['/blog']],
                            ['label' => 'Page', 'url' => ['/page']],
                            ['label' => 'Video', 'url' => 'javascript:void(0)', 'items' => [
                                    ['label' => 'Danh mục', 'url' => ['/video/category']],
                                    ['label' => 'Video', 'url' => ['/video']],
                                ]],
                    ]];
                    $items[] = ['label' => 'Cấu hình', 'url' => 'javascript:void(0)', 'items' => [
                            ['label' => 'Thành viên', 'url' => ['/user']],
                            ['label' => 'Phân quyền', 'url' => 'javascript:void(0)', 'items' => [
                                    ['label' => 'Roles', 'url' => ['/role']],
                                    ['label' => 'Permisions', 'url' => ['/permission']],
                                    ['label' => 'Route', 'url' => ['/route']],
                                ]],
                            ['label' => 'Cấu hình chung', 'url' => ['/setting']],
                        ],
                    ];

                    echo Menu::widget([
                        'items' => $items,
                        'encodeLabels' => false,
                        'itemOptions' => array('class' => 'has-submenu'),
                        'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
                        'options' => array('class' => 'navigation-menu')
                    ]);
                    ?>

                </div>
            </div>
        </div>

        <?php
    }

}
