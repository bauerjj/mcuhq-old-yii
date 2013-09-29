<?php
$this->breadcrumbs = array(
    '',
);
?>

<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;


// Place Navigation
$this->beginClip('quickLinks');
$this->widget('bootstrap.widgets.TbMenu', array(
    'type' => 'list',
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

<?php Yii::import('ext.select2.Select2'); ?>

<div class="row-fluid">
    <div class="span12 well well-small">
        <div class="span4">
            <ul class="unstyled">
                <li><b>Step 1: </b> Select Vendor<li>
                <li>
                    <?php
// Single Group
                    $data = array(
                        '','microchip', 'ti', 'ati'

                    );

                    $this->widget('ext.select2.Select2', array(
                        'attribute' => 'vendor',
                        'name' => 'vendor',
                        'data' => $data, //CHtml::listData(User::model()->findAll(), 'id', 'username'),
                        'options' => array(
                            'width' => '100%',
                            'height' => '500px',
                            'placeholder' => 'All Vendors',
                            'minimumInputLength' => 0,
                            'allowClear'=>true, // Places a small 'x'
                        ),

                        'events' => array(
                            'change' => 'js:function(e)
                                        {
                                           // alert(e.choice);
                                        }'
                        ),
                    ));
                    ?>
                </li>

            </ul>
        </div>
        <div class="span4">
            <ul class="unstyled">
                <li><b>Step 2:</b> Select Family<li>
                <li>
                    <?php
// Optgroup
                    $data = array(
                        '8-bit' => array(
                            '1' => 'PIC10',
                            '2' => 'PIC12',
                            '3' => 'PIC16',
                            '3' => 'PIC18',
                        ),
                        '16-bit' => array(
                            '4' => 'PIC24',
                            '5' => 'dsPIC',
                        ),
                        '32-bit' => array(
                            '8' => 'PIC32',
                        ),
                    );

                    $this->widget('bootstrap.widgets.TbSelect2', array(
                        'name' => 'familie',
                        'options' => array(
                            'width' => '100%',
                            'height' => '500px',
                            'placeholder' => 'All Families',
                            'minimumInputLength' => 0,
                        )
                    ));
                    ?>
                </li>
            </ul>
        </div>
        <div class="span4">
            <ul class="unstyled">
                <li><b>Step 3: </b> Select Micro <li>
                <li>
                    <?php
// Single Group
                    $data = array(
                        '1' => 'PIC16F1937',
                        '2' => 'PIC16F1947',
                        '3' => 'PIC16F1840',
                        '4' => 'PIC16F1708',
                        '5' => 'PIC16F887',
                    );

                    $this->widget('bootstrap.widgets.TbSelect2', array(
                        'name' => 'mcu',
                        'options' => array(
                            'width' => '100%',
                            'height' => '500px',
                            'placeholder' => 'All MCUs',
                            'minimumInputLength' => 0,
                        )
                    ));
                    ?>
                </li>
            </ul>
        </div>
    </div>
</div>

<?php
?>



<?php
$this->widget('bootstrap.widgets.TbListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => 'home/_viewPagination', // _view
    'template' => "{items}\n{pager}" // Puts pager on the bottom
));
?>

