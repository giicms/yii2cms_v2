<?php
/* @var $this \yii\web\View */
/* @var $content string */

use frontend\assets\AppAsset;
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
        <link rel="icon" href="/uploads/favicon/favicon.ico" type="image/x-icon" />
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <script>
            window.fbAsyncInit = function () {
                FB.init({
                    appId: '282231958808827',
                    xfbml: true,
                    version: 'v2.7'
                });
            };

            (function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {
                    return;
                }
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
        <header id="topnav">
            <div class="topbar-main">
                <div class="container">

                    <!-- LOGO -->
                    <div class="topbar-left">
                        <a href="http://videoclip24h.net" class="logo"><i class="md md-terrain"></i> <span>VIDEOCLIP24H.NET </span></a>
                    </div>
                    <!-- End Logo container-->


                    <div class="menu-extras">

                        <ul class="nav navbar-nav navbar-right pull-right">
                            <li>
                                <form role="search" class="navbar-left app-search pull-left hidden-xs">
                                    <input type="text" placeholder="Search..." class="form-control">
                                    <a href=""><i class="fa fa-search"></i></a>
                                </form>
                            </li>
                            <!--                            <li>
                                                            <a href="/cart/basket">
                                                                <div class="numcart"><i class="md md-local-grocery-store"></i>
                            <?PHP // !empty(Yii::$app->session->get('quantity')) ? '<span class="badge badge-xs badge-danger">' . Yii::$app->session->get('quantity') . ' </span>' : "" ?>
                                                                </div>  
                                                            </a>
                                                        </li>-->
                            <li>
                                <a href="/getlink">Download youtube</a>
                            </li>
<!--                              <li>
                                <a href="/facebook">Download facebook</a>
                            </li>-->
                            <?php
                            if (!Yii::$app->user->isGuest) {
                                ?>
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
                                        <li><a href="/user/profile"><i class="md md-face-unlock"></i> Thông tin cá nhân</a></li>
                                        <li><a href="/user/changepassword"><i class="md md-settings"></i> Thay đổi mật khẩu</a></li>
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
                                <?php
                            } 
                            ?>
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
            <div class="navbar-custom">
                <div class="container">
                    <div id="navigation">
                        <?php
                        echo \yii\widgets\Menu::widget([
                            'options' => ['class' => 'navigation-menu'],
                            'items' => frontend\components\MenuHelper::getMenu('video'),
                            'itemOptions' => array('class' => 'has-submenu'),
                            'submenuTemplate' => "\n<ul class='submenu'>\n{items}\n</ul>\n",
                        ])
                        ?>
                    </div>
                </div>
            </div>
        </header>
        <!-- End Navigation Bar-->


        <div class="wrapper">
            <div class="container">

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
                                2016 © Videoclip24h.net.
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- End Footer -->

            </div>
            <!-- end container -->


        </div>


        <?php $this->endBody() ?>
        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-75361345-2', 'auto');
            ga('send', 'pageview');

        </script>
    </body>
</html>
<?php $this->endPage() ?>
