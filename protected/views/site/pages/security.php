<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name . ' - About';
$this->breadcrumbs = array(
    'About',
);
?>

<h1>Report a Security Issue</h1>

<p>
    Please use the <?php echo CHtml::link('Contact Form', array('/site/contact')) ?> to report to us any security issue you find on this website.
    DO NOT use the issue tracker on github or discuss it in the public forum as it will cause more damage than help.
</p>

<p>
    Once we receive your issue report, we will treat it as our highest priority. We will
    generally take the following steps in responding to security issues.
</p>

<ol>
    <li>Confirm the issue. We may contact with you for further discussion. We will send you an acknowledgement
        after the issue is confirmed.</li>
    <li>Work on a solution.</li>
    <li>Update the website</li>
</ol>

<p><b><?php echo CHtml::link('Contact Us', array('/site/contact')) ?></b> to report a security issue.</p>