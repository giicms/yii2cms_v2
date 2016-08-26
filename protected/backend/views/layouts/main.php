<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <header id="topnav">
            <div class="topbar-main">
                <div class="container">

                    <!-- LOGO -->
                    <div class="topbar-left">
                        <a href="/admin" class="logo"><i class="md md-terrain"></i> <span>GIICMS </span></a>
                    </div>
                    <!-- End Logo container-->


                    <div class="menu-extras">

                        <ul class="nav navbar-nav navbar-right pull-right">


                            <li class="dropdown user-box">
                                <a href="" class="dropdown-toggle waves-effect waves-light profile " data-toggle="dropdown" aria-expanded="true">
                                    <?= Yii::$app->user->identity->lastname . ' ' . Yii::$app->user->identity->firstname ?>
                                    <?php
                                    if (!empty(Yii::$app->user->identity->avatar)) {
                                        echo '<img src="/uploads/thumbs/' . Yii::$app->user->identity->avatar . '" alt="user-img" class="img-circle user-img">';
                                    } else {
                                        echo '<img src="/uploads/thumbs/avatar-1.jpg" alt="user-img" class="img-circle user-img">';
                                    }
                                    ?>
                                    <div class="user-status away"><i class="zmdi zmdi-dot-circle"></i></div>
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a href="/admin/user/profile"><i class="md md-face-unlock"></i> Thông tin cá nhân</a></li>
                                    <li><a href="/admin/user/changepassword"><i class="md md-settings"></i> Thay đổi mật khẩu</a></li>
                                    <li>
                                        <?=
                                        Html::beginForm(['/site/logout'], 'post')
                                        . Html::submitButton(
                                                '<i class="md md-settings-power"></i> Thoát', ['class' => 'btn btn-link']
                                        )
                                        . Html::endForm()
                                        ?>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <div class="menu-item">
                            <!-- Mobile menu toggle-->
                            <a class="navbar-toggle">
                                <div class="lines">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </a>
                            <!-- End mobile menu toggle-->
                        </div>
                    </div>

                </div>
            </div>

            <?= backend\components\widgets\SidebarWidget::widget() ?>
        </header>
        <!-- End Navigation Bar-->


        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <?=
                    Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ])
                    ?>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?=
                        Alert::widget()
                        ?>

                    </div>
                </div>
                <!-- Page-Title -->
                <?= $content ?>
                <!-- Footer -->
                <footer class="footer text-right">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-6">
                                2016 © GIICMS.
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- End Footer -->

            </div>
            <!-- end container -->


        </div>


        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
