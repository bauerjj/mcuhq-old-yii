<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name . ' - About';
$this->breadcrumbs = array(
    'About',
);

$cs = Yii::app()->getClientScript();
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.githubRepoWidget.min.js');
?>

<?php
$this->Widget(
        'bootstrap.widgets.TbHeroUnit', array(
    'heading' => 'Welcome to mcuhq.com',
            'content' => 'This is a projects and tutorial site for professional and hobbyist engineers that have a passion for
microcontrollers. It is built and run by <i>you</i>. With your help, we can create a database full of
information about microcontrollers</p>'
        )
);
?>


<p>This site is a little different from other typical sites. Here are a few reasons:</p>

<hr>

<div class="row-fluid">
    <div class="span7">
        <h1><i class="fa fa-github"></i> open source and free to use</h1>
        <p><b>mcuhq</b> strives for collaboration, which is why the source code for this entire website is openly avaliable to download and use!</p>
    </div>
    <div class="span5">
        <div class="github-widget" data-repo="mcuhq/mcuhq"></div>
    </div>
</div>

<hr>

<h1><i class="fa fa-bullseye"></i> Content must be detailed and accurate</h1>
<div class="row-fluid">
    <div class="span8">
        <p><b>mcuhq</b> was born out of frustration from other websites that hosted content that was disorganized,
            dysfunctional, and left unsupported. All content that is submitted on this site should be formatted and
            detailed in such a way that another reader is able to follow along and complete it with success.</p>
    </div>
    <div class="span4">
        <a href="#" class="thumbnail">
            <img src="http://placehold.it/260x180" alt="">
        </a>
    </div>
</div>
<div class="row-fluid">
    <div class="span8">
        <p>It is strongly encouraged that links to external software control repositories are used such as <a href="https://github.com">github</a>
            and <a href="https://bitbucket.com">bitbucket</a>. This will make it easier for readers to stay up-to-date with your work and even improve it!
        </p>
    </div>
    <div class="span4">
        <a href="#" class="thumbnail">
            <img src="http://placehold.it/260x180" alt="">
        </a>
    </div>
</div>

<hr>
<h1><i class="fa fa-exclamation"></i> You own the content</h1>
<div class="row-fluid">
    <div class="span8">
        <p>Since you did all of the hard work, you get to claim ownership. All submitted content should specify a license, whether
            it be restrictive or not is up to you!</p>
    </div>
    <div class="span4">
        <a href="#" class="thumbnail">
            <img src="http://placehold.it/100x80" alt="">
        </a>
    </div>
</div>

<hr>

<h1><i class="fa fa-code-fork"></i> Improve content by commenting and forking</h1>
<div class="row-fluid">
    <div class="span8">
        The intent is to have the <b>best</b> articles, so please help by contributing constructive feedback
        in the comments section or forking a project/tutorial and improving it.
    </div>
    <div class="span4">
        <a href="#" class="thumbnail">
            <img src="http://placehold.it/100x80" alt="">
        </a>
    </div>

</div>

<hr>


<h1><i class="fa fa-flag-o"></i> User Moderation</h1>
<div class="row-fluid">
    <div class="span8">
        <p>Good content should be voted up whilst sub par should be voted down and given a reason. Content that does not fit the context of this site
            or is inappropriate should be flagged <i class="icon-flag-alt icon-1x flag"></i> for removal.</p>

        <p>Any website bugs and errors should be reported to this site's <a href="https://github.com/mcuhq/mcuhq/issues/new">issues github page</a>.
            Security holes should be emailed directly to the admin.

        </p>
    </div>
    <div class="span4">
        <a href="#" class="thumbnail">
            <img src="http://placehold.it/100x80" alt="">
        </a>
    </div>
</div>

<hr>

<h1><i class="fa fa-check" ></i> General Checklist</h1>
Here is a basic checklist before submitting:
<div class="row-fluid">
    <?php
    $this->widget(
            'bootstrap.widgets.TbDetailView', array(
        'data' => array(
            'id' => 1,
            'accurate' => '<i class="fa fa-check-square-o" style = "color: green"></i>',
            'easy to read' => '<i class="fa fa-check-square-o" style = "color: green"></i>',
            'repeatable' => '<i class="fa fa-check-square-o" style = "color: green"></i>',
            'relevant' => '<i class="fa fa-check-square-o" style = "color: green"></i>'
        ),
        'type' => 'bordered',
        'attributes' => array(
            array('name' => 'accurate', 'label' => 'Accurate', 'type' => 'raw'),
            array('name' => 'easy to read', 'label' => 'Easy To Read', 'type' => 'raw'),
            array('name' => 'repeatable', 'label' => 'Repeatable', 'type' => 'raw'),
            array('name' => 'relevant', 'label' => 'Relevant To Microcontrollers', 'type' => 'raw'),
        ),
            )
    );
    ?>
</div>


