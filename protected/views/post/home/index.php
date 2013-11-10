

<?php
/* @var $this SiteController */

// No breadcrumbs on main page

$this->pageTitle = Yii::app()->name;

$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl . '/js/filter-custom.js');



// Place Navigation
$this->beginClip('quickLinks');
$this->widget('bootstrap.widgets.TbNav', array(
    'type' => TbHtml::NAV_TYPE_LIST,
    'items' => array(
        array('label' => 'Quick Links'),
        array('label' => 'Get Started', 'icon' => 'icon-play-circle', 'url' => '#', 'active' => false),
        array('label' => 'Projects', 'icon' => 'icon-tasks', 'url' => '#', 'active' => false),
        array('label' => 'Tutorials', 'icon' => 'book', 'url' => '#'),
        array('label' => 'News', 'icon' => 'icon-file', 'url' => '#'),
        array('label' => 'Adv Search', 'icon' => 'icon-search', 'url' => '#'),
        array('label' => 'Forum', 'icon' => 'icon-certificate', 'url' => '#'),
    ),
));
$this->endClip();
?>

<?php //Yii::import('ext.select2.Select2'); ?>

<div class="row-fluid">
    <div class="span12 well well-small">
        <div class="span4">
            <ul class="unstyled">
                <li><b>Step 1: </b> Select Vendor<li>
                <li>
                    <?php
                    $options = array();
                    $options["options"] = array(
                        "1" => array(
                            "style" => "color:red"),
                        "2" => array(
                            "style" => "color:blue"
                        )
                    );
                    $data = CHtml::listData(Vendor::model()->findAll(), 'id', 'name');
                    foreach ($data as $id => $row) {
                        $options["options"][$id] = array('count' => 6);
                    }
                    $data = array_merge(array('' => ''), $data);

                    $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
                        'attribute' => 'vendor',
                        'name' => 'vendor',
                        'data' => $data, //CHtml::listData(User::model()->findAll(), 'id', 'username'),
                        //  'htmlOptions' => $options,
                        'pluginOptions' => array(
                            'width' => '100%',
                            'height' => '500px',
                            'placeholder' => 'All Vendors',
                            'minimumInputLength' => 0,
                            'allowClear' => true, // Places a small 'x'
                            'formatResult' => 'js:function(data){ return format(data) }',
                        ),
                        'events' => array(
                            'selected' => 'js:function(e)
                                        {
                                          postData("vendor");
                                        }',
                            'removed' => 'js:function(e)
                                        {
                                          postData("vendor-removed");
                                        }'
                        ),
                    ));
                    ?>
                </li>

            </ul>
        </div>
        <div class="span4" id="select-family">
            <ul class="unstyled">
                <li><b>Step 2:</b> Select Family<li>
                <li>
                    <?php
                    $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
                        'name' => 'family',
                        'data' => array('' => ''),
                        'pluginOptions' => array(
                            'width' => '100%',
                            'height' => '500px',
                            'placeholder' => 'All Families',
                            'minimumInputLength' => 0,
                            'allowClear' => true, // Places a small 'x'
                            'formatResult' => 'js:function(data){ return format(data) }',
                        ),
                        'events' => array(
                            'selected' => 'js:function(e)
                                            {
                                                postData("family");
                                            }',
                            'removed' => 'js:function(e)
                                        {
                                          postData("family-removed");
                                        }'
                        )
                    ));
                    ?>
                </li>
            </ul>
        </div>
        <div class="span4" id="select-micro">
            <ul class="unstyled">
                <li><b>Step 3: </b> Select Micro <li>
                <li>
                    <?php
                    $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
                        'name' => 'micro',
                        'data' => array('' => ''),
                        'asDropDownList' => true,
                        'pluginOptions' => array(
                            'width' => '100%',
                            'height' => '500px',
                            'placeholder' => 'All MCUs',
                            'minimumInputLength' => 0,
                            'allowClear' => true, // Places a small 'x'
                            'formatResult' => 'js:function(data){ return format(data) }',
                        ),
                        'events' => array(
                            'selected' => 'js:function(e)
                                            {
                                                postData("micro");
                                            }',
                            'removed' => 'js:function(e)
                                        {
                                          postData("micro-removed");
                                        }'
                        )
                    ));
                    ?>
                </li>
            </ul>
        </div>
    </div>
</div>

<?php
echo CHtml::ajaxLink('test me', Yii::app()->createUrl('post/test'), array(
    'type' => 'POST',
    'success' => "function(data){ console.log(data)}",
        )
);
?>



<?php
$this->widget('bootstrap.widgets.TbListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => 'home/_viewPagination', // _view
    'template' => "{items}\n{pager}" // Puts pager on the bottom
));
?>
