<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.ico" type="image/x-icon" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/custom.css" />

        <?php Yii::app()->bootstrap->register(); ?>
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.1/css/font-awesome.css" rel="stylesheet" />

    </head>

    <body>
        <?php // ob_start(); ?>
        <!--        <div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
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
                </div>-->
        <?php //$html = ob_get_clean(); ?>


        <?php
        $this->widget('bootstrap.widgets.TbNavbar', array(
            //  'type' => '', // null or 'inverse'
            'brandLabel' => 'mcuhq.com',
            'display' => 'static',
            'brandUrl' => 'http://mcuhq.com',
            'collapse' => false, // requires bootstrap-responsive.css
            'items' => array(
                array(
                    'class' => 'bootstrap.widgets.TbNav',
                    'items' => array(
                        array('label' => 'About', 'url' => array('/site/page', 'view' => 'about'), 'icon' => 'question-sign'), //question-sign white
                        array('label' => 'Contribute', 'icon' => 'pencil', 'items' => array(
                                array('label' => 'Submit a Project/Tutorial', 'url' => array('/post/create'), 'icon' => 'icon-ok'),
                                array('label' => 'Report a Site Bug', 'url' => 'https://github.com/mcuhq/mcuhq/issues/new', 'icon' => 'icon-wrench'),
                                array('label' => 'Report a Site Security Issue', 'url' => array('/site/page', 'view' => 'security'), 'icon' => 'icon-warning-sign'),
                            )),
                        array('label' => 'Login/Register', 'url' => Yii::app()->getModule('user')->loginUrl, 'visible' => Yii::app()->user->isGuest), 'items' => array(
                            array($html)
                        ),
                        array('label' => 'Welcome, ' . Yii::app()->user->name, 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest, 'icon' => 'user', 'items' => array(
                                array('label' => Yii::app()->getModule('user')->t("Profile"), 'url' => Yii::app()->getModule('user')->profileUrl, 'icon' => 'cog'),
                                array('label' => 'Contact Support', 'url' => '#', 'icon' => 'envelope'),
                                '---',
                                array('label' => 'Logout', 'url' => Yii::app()->getModule('user')->logoutUrl, 'icon' => 'off'),
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
                '<form class="navbar-search form-search pull-right" action=""><div class="input-append"><input type="text" class="search-query span3" placeholder="Search"><button type="submit" class="btn">Go</button></div></form>',
                array(
                    'class' => 'bootstrap.widgets.TbNav',
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

        <div class="container">
            <div class="content">
                <?php if (isset($this->breadcrumbs)): ?>
                    <?php
                    $this->widget('bootstrap.widgets.TbBreadcrumb', array(
                        'links' => $this->breadcrumbs,
                    ));
                    ?><!-- breadcrumbs -->
                <?php endif ?>

                <?php echo $content; ?>
            </div>
            <div class="clear"></div>

            <div id ="footer" class="container-fluid">

                <div class="row-fluid">
                    <div class="span12">
                        <div class="span8">
                            <?php echo CHtml::link('About', array('/site/page', 'view' => 'about')) ?>
                            | <a href="#">Help</a>
                            | <a href="#">Blog</a>
                            | <a href="#">Legal</a>
                            | <a href="#">Privacy Policy</a>
                            | <a href="#">Advertising Info</a>
                            | <a href="#">Open Source Software </a>
                            | <b><?php echo CHtml::link('Contact/Feedback', array('/site/contact')) ?></b>
                        </div>
                        <div class="span4">
                            <span class="muted pull-right">Copyright &copy; <?php echo date('Y'); ?> mcuhq. Some Rights Reserved. <?php // echo Yii::powered();        ?></span>
                        </div>
                    </div>
                </div>


                <div class="row-fluid">
                    <div class="span12">
                        <div class="span2" style="width: 15%;">
                            <ul class="unstyled">
                                <li>GitHub</li>


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


                                                                                            </div>

                                                                                            <!-- footer -->

                                                                                            </body>
                                                                                            </html>
