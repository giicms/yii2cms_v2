<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\components\widgets;

use Yii;
use yii\base\Widget;
use giicms\tour\models\Category;

class Header extends Widget {

    public function init() {
        
    }

    public function run() {
        $category = Category::find()->where(['type' => 'tour'])->all();
        ?>

        <div class="header-outer-wrapper full-slider">
            <div class="header-area-wrapper">
                <!-- top navigation -->
                <div class="top-navigation-wrapper boxed-style">
                    <div class="top-navigation-container container">
                        <div class="top-social-wrapper"><div id="gdl-social-icon" class="social-wrapper gdl-retina">
                                <div class="social-icon-wrapper"><div class="social-icon"><a target="_blank" href="#">
                                            <img src="http://demo.goodlayers.com/tourpackage/wp-content/themes/packagetour/images/icon/social-icon/facebook.png" alt="facebook" width="18" height="18" /></a></div><div class="social-icon"><a target="_blank" href="#"><img src="http://demo.goodlayers.com/tourpackage/wp-content/themes/packagetour/images/icon/social-icon/linkedin.png" alt="linkedin" width="18" height="18" /></a></div><div class="social-icon"><a target="_blank" href="#"><img src="http://demo.goodlayers.com/tourpackage/wp-content/themes/packagetour/images/icon/social-icon/twitter.png" alt="twitter" width="18" height="18" /></a></div><div class="social-icon"><a target="_blank" href="#"><img src="http://demo.goodlayers.com/tourpackage/wp-content/themes/packagetour/images/icon/social-icon/email.png" alt="email" width="18" height="18" /></a></div><div class="social-icon"><a target="_blank" href="#"><img src="http://demo.goodlayers.com/tourpackage/wp-content/themes/packagetour/images/icon/social-icon/pinterest.png" alt="pinterest" width="18" height="18" /></a></div></div></div></div><div class="top-navigation-left-text">Your tags line here</div><div class="top-search-wrapper">									<div class="gdl-search-form">
                                <form method="get" id="searchform" action="">
                                    <input type="submit" id="searchsubmit" value="" />
                                    <div class="search-text" id="search-text">
                                        <input type="text" value="" name="s" id="s" autocomplete="off" data-default="" />
                                    </div>
                                    <div class="clear"></div>
                                </form>
                            </div>
                        </div>
                        <div class="top-navigation-right-text"><div style="float:left; ">
                                <img src="http://demo.goodlayers.com/tourpackage/wp-content/uploads/2013/08/icon-mail.png" style="width: 14px; float: left; margin-top: 3px; " alt=""/>
                                <span style="margin-right: 15px; margin-left:  9px; font-size: 12px; line-height: 14px; color: #fff; ">contact@packagetourtheme.us</span>
                            </div>
                            <div style="float:left; ">
                                <img src="http://demo.goodlayers.com/tourpackage/wp-content/uploads/2013/08/icon-phone.png" style="width: 12px; float: left; margin-top: 3px;" alt=""/>
                                <span style="margin-left:  9px; font-size: 12px; line-height: 14px;  color: #fff;">1800-1232-4234</span>
                            </div></div>							<div class="clear"></div>
                    </div>
                </div> <!-- top navigation wrapper -->

                <div class="header-wrapper boxed-style">
                    <div class="header-container container">
                        <!-- Get Logo -->
                        <div class="logo-wrapper">
                            <h1><a href="e"><img width="200" src="http://demo.goodlayers.com/tourpackage/wp-content/uploads/2013/08/logo.png" alt=""/></a></h1>						</div>

                        <!-- Navigation -->
                        <div class="gdl-navigation-wrapper">
                            <div class="responsive-menu-wrapper">
                                <select id="menu-main" class="menu dropdown-menu">
                                    <option value="" class="blank">&#8212; Main Menu &#8212;</option>
                                    <option class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-3896 current_page_item menu-item-has-children menu-item-4371 menu-item-depth-0" value="http://demo.goodlayers.com/tourpackage/" selected="selected">Home</option>	<option class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4370 menu-item-depth-1" value="http://demo.goodlayers.com/tourpackage/homepage-ex-2/">- Homepage Ex 2</option>
                                    <option class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4369 menu-item-depth-1" value="http://demo.goodlayers.com/tourpackage/homepage-ex-3/">- Homepage Ex 3</option>
                                    <option class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4353 menu-item-depth-1" value="http://demo.goodlayers.com/tourpackage/homepage-corporate-style/">- Homepage Corporate Style</option>
                                    <option class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4354 menu-item-depth-1" value="http://demo.goodlayers.com/tourpackage/homepage-corporate-2/">- Homepage Corporate Style 2</option>


                                    <option class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4299 menu-item-depth-0" value="http://demo.goodlayers.com/tourpackage/contact/">Contact</option>
                                </select>
                            </div>
                            <div class="clear"></div>
                            <div class="navigation-wrapper sliding-bar">
                                <div class="gdl-current-menu" >

                                </div>
                                <div class="main-superfish-wrapper" id="main-superfish-wrapper" >
                                    <ul class="sf-menu">
                                        <li>
                                            <a href="">Trang chủ</a>
                                        </li>
                                        <li>
                                            <a href="">Giới thiệu</a>
                                        </li>
                                        <li>
                                            <a href="">Tour du lịch</a>
                                            <ul class="sub-menu">

                                                <?php
                                                if (!empty($category)) {
                                                    foreach ($category as $value) {
                                                        ?>
                                                        <li><a href=""><?= $value->title ?></a></li>
                                                        <?php
                                                    }
                                                }
                                                ?>


                                            </ul>
                                        </li>
                                        <li>
                                            <a href="">Cẩm nang du lịch</a>
                                        </li>
                                        <li>
                                            <a href="">Liên hệ</a>
                                        </li>
                                    </ul>
                                    <div class="clear"></div>

                                </div>
                                <div class="clear"></div>

                            </div>				
                            <div class="clear"></div>
                        </div>
                        <div class="clear"></div>
                    </div> <!-- header container -->
                </div> <!-- header area -->		
            </div> <!-- header wrapper -->		
            <div class="gdl-top-slider">
                <div class="gdl-top-slider-wrapper full-slider">

                    <div id="layerslider_1" class="ls-wp-container" style="width:100%;height:560px;margin:0 auto;margin-bottom: 0px;"><div class="ls-slide" data-ls="slidedelay:8000; transition2d: all;"><img src="http://themes.goodlayers2.com/tourpackage/wp-content/uploads/2013/08/slider-1.jpg" class="ls-bg" alt="Slide background" /><div class="ls-l" style="top:213px;left:480px;font-family: 'Open Sans'; font-size: 68px; font-weight: 100; color: #111; background: #fff; padding: 5px 20px; -moz-border-radius: 8px; border-radius: 8px; ;white-space: nowrap;" data-ls="offsetxin:right;delayin:500;fadein:false;offsetxout:left;durationout:1000;fadeout:false;">Travel With Us</div><div class="ls-l" style="top:331px;left:651px;font-family: 'Open Sans'; font-size: 39px; color: #444; font-weight: 100;white-space: nowrap;" data-ls="offsetxin:right;delayin:1000;fadein:false;offsetxout:left;durationout:1000;fadeout:false;">For The Best Deal </div></div><div class="ls-slide" data-ls="slidedelay:8000; transition2d: all;"><img src="http://themes.goodlayers2.com/tourpackage/wp-content/uploads/2013/08/slider-5.jpg" class="ls-bg" alt="Slide background" /><img class="ls-l" style="top:138px;left:611px;white-space: nowrap;" data-ls="offsetxin:0;offsetyin:bottom;delayin:500;fadein:false;offsetxout:0;offsetyout:bottom;durationout:1000;fadeout:false;" src="http://themes.goodlayers2.com/tourpackage/wp-content/uploads/2013/08/traveller.png" alt="image"><div class="ls-l" style="top:164px;left:42px;font-family: 'Open Sans'; font-size: 38px; font-weight: 100; color: #111; padding: 5px 20px; background: rgb(255, 255, 255); background: rgba(255, 255, 255, 0.8);white-space: nowrap;" data-ls="offsetxin:0;offsetyin:top;delayin:800;fadein:false;offsetxout:0;offsetyout:top;durationout:1000;fadeout:false;">Best For Travelling Website</div><div class="ls-l" style="top:240px;left:43px;font-family: #fff; font-size: 19px; padding: 10px 20px 10px 40px; font-family: 'Open Sans'; color: #ffffff; background: rgb(0, 0, 0); background: rgba(0, 0, 0, 0.7);white-space: nowrap;" data-ls="offsetxin:left;delayin:1100;fadein:false;offsetxout:left;durationout:1000;fadeout:false;">Pacakge Post Type</div><img class="ls-l" style="top:254px;left:57px;white-space: nowrap;" data-ls="offsetxin:left;delayin:1300;fadein:false;offsetxout:left;durationout:1000;fadeout:false;" src="http://themes.goodlayers2.com/tourpackage/wp-content/uploads/2013/08/star.png" alt="image"><div class="ls-l" style="top:289px;left:43px;font-family: #fff; font-size: 19px; padding: 10px 20px 10px 40px; font-family: 'Open Sans'; color: #ffffff; background: rgb(0, 0, 0); background: rgba(0, 0, 0, 0.7);white-space: nowrap;" data-ls="offsetxin:left;delayin:1400;fadein:false;offsetxout:left;durationout:1000;fadeout:false;">Booking Form by Contact Form 7</div><img class="ls-l" style="top:304px;left:57px;white-space: nowrap;" data-ls="offsetxin:left;delayin:1600;fadein:false;offsetxout:left;durationout:1000;fadeout:false;" src="http://themes.goodlayers2.com/tourpackage/wp-content/uploads/2013/08/star.png" alt="image"><div class="ls-l" style="top:338px;left:43px;font-family: #fff; font-size: 19px; padding: 10px 20px 10px 40px; font-family: 'Open Sans'; color: #ffffff; background: rgb(0, 0, 0); background: rgba(0, 0, 0, 0.7);white-space: nowrap;" data-ls="offsetxin:left;delayin:1700;fadein:false;offsetxout:left;durationout:1000;fadeout:false;">Package Discount Feature</div><img class="ls-l" style="top:353px;left:57px;white-space: nowrap;" data-ls="offsetxin:left;delayin:1900;fadein:false;offsetxout:left;durationout:1000;fadeout:false;" src="http://themes.goodlayers2.com/tourpackage/wp-content/uploads/2013/08/star.png" alt="image"><div class="ls-l" style="top:387px;left:43px;font-family: #fff; font-size: 19px; padding: 10px 20px 10px 40px; font-family: 'Open Sans'; color: #ffffff; background: rgb(0, 0, 0); background: rgba(0, 0, 0, 0.7);white-space: nowrap;" data-ls="offsetxin:left;delayin:2000;fadein:false;offsetxout:left;durationout:1000;fadeout:false;">Pakcage Filtering System</div><img class="ls-l" style="top:401px;left:57px;white-space: nowrap;" data-ls="offsetxin:left;delayin:2200;fadein:false;offsetxout:left;durationout:1000;fadeout:false;" src="http://themes.goodlayers2.com/tourpackage/wp-content/uploads/2013/08/star.png" alt="image"></div><div class="ls-slide" data-ls="slidedelay:8000; transition2d: all;"><img src="http://themes.goodlayers2.com/tourpackage/wp-content/uploads/2013/08/slider-4.jpg" class="ls-bg" alt="Slide background" /><div class="ls-l" style="top:194px;left:516px;font-family: #fff; font-size: 41px; padding: 5px 15px; font-family: 'Open Sans'; color: #ffffff; font-weight: 100; -moz-border-radius: 5px; border-radius: 5px; background: rgb(0, 0, 0); background: rgba(0, 0, 0, 0.7);white-space: nowrap;" data-ls="offsetxin:right;delayin:1200;fadein:false;offsetxout:right;durationout:1000;fadeout:false;">Perfect on any devices</div><div class="ls-l" style="top:293px;left:609px;font-family: #fff; font-size: 22px; font-family: 'Open Sans'; color: #ffffff; font-weight: bold; text-align: right;white-space: nowrap;" data-ls="offsetxin:right;delayin:1500;fadein:false;offsetxout:right;durationout:1000;fadeout:false;">Your customers can enjoy your <br>
                                website anywhere.
                            </div>
                            <div class="ls-l" style="top:371px;left:722px;font-family: #fff; font-size: 44px; font-family: 'Open Sans'; color: #ffffff; font-style: italic; font-weight: 100;white-space: nowrap;" data-ls="offsetxin:right;delayin:1800;fadein:false;offsetxout:right;durationout:1000;fadeout:false;">It's just Neat.</div><img class="ls-l" style="top:171px;left:17px;white-space: nowrap;" data-ls="offsetxin:0;offsetyin:top;delayin:300;fadein:false;offsetxout:0;offsetyout:top;durationout:1000;fadeout:false;" src="http://themes.goodlayers2.com/tourpackage/wp-content/uploads/2013/08/item-11.png" alt="image"><img class="ls-l" style="top:312px;left:324px;white-space: nowrap;" data-ls="offsetxin:0;offsetyin:bottom;delayin:600;fadein:false;offsetxout:0;offsetyout:bottom;durationout:1000;fadeout:false;" src="http://themes.goodlayers2.com/tourpackage/wp-content/uploads/2013/08/item-21.png" alt="image"><img class="ls-l" style="top:382px;left:237px;white-space: nowrap;" data-ls="offsetxin:left;delayin:900;fadein:false;offsetxout:left;durationout:1000;fadeout:false;" src="http://themes.goodlayers2.com/tourpackage/wp-content/uploads/2013/08/item-31.png" alt="image"></div><div class="ls-slide" data-ls="slidedelay:8000; transition2d: all;"><img src="http://themes.goodlayers2.com/tourpackage/wp-content/uploads/2013/08/slider-3.jpg" class="ls-bg" alt="Slide background" /><img class="ls-l" style="top:136px;left:40px;white-space: nowrap;" data-ls="offsetxin:0;offsetyin:top;delayin:500;fadein:false;offsetxout:0;offsetyout:top;durationout:1000;fadeout:false;" src="http://themes.goodlayers2.com/tourpackage/wp-content/uploads/2013/08/award-logo.png" alt="image"><img class="ls-l" style="top:280px;left:96px;white-space: nowrap;" data-ls="offsetxin:0;offsetyin:bottom;delayin:800;fadein:false;offsetxout:0;offsetyout:bottom;durationout:1000;fadeout:false;" src="http://themes.goodlayers2.com/tourpackage/wp-content/uploads/2013/08/cup.png" alt="image"><div class="ls-l" style="top:334px;left:56px;font-family: #fff; font-size: 22px; font-family: 'Open Sans'; color: #1c5b6d; font-weight: 100;white-space: nowrap;" data-ls="offsetxin:0;delayin:1500;offsetxout:0;durationout:1000;">We're an award</div><div class="ls-l" style="top:367px;left:19px;font-family: #fff; font-size: 32px; font-family: 'Open Sans'; color: #1c5b6d; font-weight: bold; ;white-space: nowrap;" data-ls="offsetxin:0;delayin:2000;offsetxout:0;durationout:1000;">Winning Agent</div></div><div class="ls-slide" data-ls="slidedelay:8000; transition2d: all;"><img src="http://themes.goodlayers2.com/tourpackage/wp-content/uploads/2013/08/slider-2.jpg" class="ls-bg" alt="Slide background" /><div class="ls-l" style="top:166px;left:120px;font-family: #fff; font-size: 36px; padding: 5px 15px; font-family: 'Open Sans'; color: #ffffff; font-weight: 100; -moz-border-radius: 5px; border-radius: 5px; background: rgb(0, 0, 0); background: rgba(0, 0, 0, 0.7);white-space: nowrap;" data-ls="offsetxin:0;delayin:300;offsetxout:0;durationout:1000;">We have 10 years of experience in this field.</div><div class="ls-l" style="top:253px;left:204px;font-family: #fff; font-size: 26px; font-family: 'Open Sans'; color: #ffffff; font-style: italic;white-space: nowrap;" data-ls="offsetxin:0;delayin:1000;offsetxout:0;durationout:1000;">With more than 1000 employees across the globe.
                            </div>

                        </div>

                    </div>
                    <div class="clear"></div>

                </div>

            </div>
        </div>
        <?php
    }

}
