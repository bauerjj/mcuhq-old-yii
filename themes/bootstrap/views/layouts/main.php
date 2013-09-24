<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.ico" type="image/x-icon" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />


        <title><?php echo CHtml::encode($this->pageTitle); ?></title>


        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/custom.css" />
    </head>

    <body>
        <?php ob_start(); ?>
            <div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
                <form method="post" action="login" accept-charset="UTF-8">
                    <input style="margin-bottom: 15px;" type="text" placeholder="Username" id="username" name="username"></input>
                    <input style="margin-bottom: 15px;" type="password" placeholder="Password" id="password" name="password"></input>
                    <input style="float: left; margin-right: 10px;" type="checkbox" name="remember-me" id="remember-me" value="1"></input>
                    <label class="string optional" for="user_remember_me"> Remember me</label>
                    <input class="btn btn-primary btn-block" type="submit" id="sign-in" value="Sign In"></input>
                    <label style="text-align:center;margin-top:5px">or</label>
                    <input class="btn btn-primary btn-block" type="button" id="sign-in-google" value="Sign In with Google"></input>
                    <input class="btn btn-primary btn-block" type="button" id="sign-in-twitter" value="Sign In with Twitter"></input>
                </form>
            </div>
        <?php
$html = ob_get_clean(); ?>


        <?php
        $this->widget('bootstrap.widgets.TbNavbar', array(
            'type' => 'inverse', // null or 'inverse'
            'brand' => 'MCUHQ',
            'fixed' => 'static', // top or bottom
            'brandUrl' => '#',
            'collapse' => true, // requires bootstrap-responsive.css
            'items' => array(
                array(
                    'class' => 'bootstrap.widgets.TbMenu',
                    'items' => array(
                        array('label' => 'About', 'url' => array('/site/page', 'view' => 'about'), 'icon' => 'question-sign white'),
                        array('label' => 'Contribute', 'url' => array('/site/contact'), 'icon' => 'pencil white', 'items' => array(
                                array('label' => 'Submit an Article', 'url' => '#', 'icon' => 'icon-ok'),
                                array('label' => 'Report a Bug', 'url' => 'https://github.com/mcuhq/mcuhq/issues/new', 'icon' => 'icon-wrench'),
                                array('label' => 'Report a Security Issue', 'url' => '#', 'icon' => 'icon-warning-sign'),
                            )),
                        array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest), 'items'=>array(
                            array($html)
                        ),
                        array('label' => 'Welcome, ' . Yii::app()->user->name, 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest, 'icon' => 'user white', 'items' => array(
                                array('label' => 'Profile', 'url' => '#', 'icon' => 'cog'),
                                array('label' => 'Contact Support', 'url' => '#', 'icon' => 'envelope'),
                                '---',
                                array('label' => 'Logout', 'url' => array('site/logout'), 'icon' => 'off'),
                            )),
                    ),
                ),
                /* '<form class="navbar-search form-search pull-right" action="">
                  <div class="input-append">
                  <input type="text" class="search-query span3" placeholder="Search">
                  <div class="btn-group">
                  <button type="submit" class="btn btn-inverse dropdown-toggle" data-toggle="dropdown">
                  Go
                  <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                  <li>all</li>
                  </ul>
                  </div>
                  </div>
                  </form>', */
                '<form class="navbar-search form-search pull-right" action=""><div class="input-append"><input type="text" class="search-query span3" placeholder="Search"><button type="submit" class="btn btn-inverse">Go</button></div></form>',
                array(
                    'class' => 'bootstrap.widgets.TbMenu',
                    'htmlOptions' => array('class' => 'pull-right'),
                    'items' => array(
                        array('label' => 'All', 'url' => '#', 'items' => array(
                                array('label' => '8-bit', 'url' => '#'),
                                array('label' => '16-bit', 'url' => '#'),
                                array('label' => '32-bit', 'url' => '#'),
                                '---',
                                array('label' => 'MCU', 'url' => '#'),
                                array('label' => 'Microchip', 'url' => '#'),
                                array('label' => 'ATMEL', 'url' => '#'),
                            )),
                    ),
                ),
            ),
        ));
        ?>

        <div class="container-fluid" id="page">

            <?php if (isset($this->breadcrumbs)): ?>
                <?php
                $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
                    'links' => $this->breadcrumbs,
                ));
                ?><!-- breadcrumbs -->
            <?php endif ?>

            <?php echo $content; ?>

            <div class="clear"></div>

            <div id ="footer" class="container-fluid">

                <div class="row-fluid">
                    <div class="span12">
                        <div class="span8">
                            <a href="#">About</a>
                            | <a href="#">Help</a>
                            | <a href="#">Blog</a>
                            | <a href="#">Legal</a>
                            | <a href="#">Privacy Policy</a>
                            | <a href="#">Advertising Info</a>
                            | <a href="#">Open Source Software </a>
                            | <b><a href="#">Contact/Feedback</a></b>
                        </div>
                        <div class="span4">
                            <span class="muted pull-right">Copyright &copy; <?php echo date('Y'); ?> mcuhq. Some Rights Reserved. <?php // echo Yii::powered();     ?></span>
                        </div>
                    </div>
                </div>


                <div class="row-fluid">
                    <div class="span12">
                        <div class="span2" style="width: 15%;">
                            <ul class="unstyled">
                                <li>GitHub<li>
                                        <li><iframe src="http://ghbtns.com/github-btn.html?user=mcuhq&type=follow&count=true"
                                                    allowtransparency="true" frameborder="0" scrolling="0" width="165" height="20"></iframe>  </li>
                                        <li><iframe src="http://ghbtns.com/github-btn.html?user=mcuhq&repo=mcuhq&type=watch&count=true"
                                                    allowtransparency="true" frameborder="0" scrolling="0" width="110" height="20"></iframe></li>
                                        <li><iframe src="http://ghbtns.com/github-btn.html?user=mcuhq&repo=mcuhq&type=fork&count=true"
                                                    allowtransparency="true" frameborder="0" scrolling="0" width="95" height="20"></iframe></li>


                                        </ul>
                                        </div>
                                        <div class="span2" style="width: 15%;">
                                            <ul class="unstyled">
                                                <li>Top Microcontroller Vendors<li>
                                                        <li><a href="#">Freescale</a></li>
                                                        <li><a href="#">Atmel</a></li>
                                                        <li><a href="#">Texas Instruments</a></li>
                                                        <li><a href="#">STMicroelectronics</a></li>
                                                        </ul>
                                                        </div>
                                                        <div class="span2" style="width: 15%;">
                                                            <ul class="unstyled">
                                                                <li>&nbsp; <li>
                                                                        <li><a href="#">NXP</a></li>
                                                                        <li><a href="#">Intel</a></li>
                                                                        <li><a href="#">Cypress</a></li>
                                                                        <li><a href="#">Microchip Technology</a></li>
                                                                        </ul>
                                                                        </div>
                                                                        <div class="span2" style="width: 15%;">
                                                                            <ul class="unstyled">
                                                                                <li>&nbsp;<li>
                                                                                        <li><a href="#">Renesas</a></li>
                                                                                        <li><a href="#">Silicon Laboratories</a></li>
                                                                                        <li><a href="#">Infineon</a></li>
                                                                                        <li><a href="#">Maxim Integrated</a></li>
                                                                                        </ul>
                                                                                        </div>
                                                                                        <div class="span2" style="width: 15%;">
                                                                                            <ul class="unstyled">
                                                                                                <li>&nbsp;<li>
                                                                                                        <li><a href="#">Holtek</a></li>
                                                                                                        <li><a href="#">EPSON Semiconductor</a></li>
                                                                                                        <li><b><a href="#">More (13)</a></b></li>
                                                                                                        </ul>
                                                                                                        </div>
                                                                                                        </div>
                                                                                                        </div>
                                                                                                        <hr>

                                                                                                            </div>




                                                                                                            <!-- footer -->

                                                                                                            </div><!-- page -->

                                                                                                            </body>
                                                                                                            </html>
