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


                    $this->widget('ext.select2.ESelect2', array(
                        'attribute' => 'vendor',
                        'name' => 'vendor',
                        'data' => $data, //CHtml::listData(User::model()->findAll(), 'id', 'username'),
                      //  'htmlOptions' => $options,
                        'options' => array(
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
                    $this->widget('ext.select2.ESelect2', array(
                        'name' => 'family',
                       // 'data' => $data,
                        'options' => array(
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
                    $this->widget('ext.select2.ESelect2', array(
                        'name' => 'micro',
                       //  'data' => $data,
                        'options' => array(
                            'width' => '100%',
                            'height' => '500px',
                            'placeholder' => 'All MCUs',
                            'minimumInputLength' => 0,
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
//CHtml::dropDownList
?>



<?php
$this->widget('bootstrap.widgets.TbListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => 'home/_viewPagination', // _view
    'template' => "{items}\n{pager}" // Puts pager on the bottom
));
?>

<script>
    function postData(type) {
       // alert($('#vendor').select2('val') + ', ' + $('#family').select2('val') + ', ' + $('#micro').select2('val'));

        $.ajax({
            url: "<?php echo Yii::app()->createUrl('post/filter') ?>",
            type: 'POST',
            data: {'type': type, 'vendorId': $('#vendor').val(), 'familyId': $('#family').val(), 'microId': $('#micro').val()},
            success: function(data) {
                var data = $.parseJSON(data); // Parse the JSON from controller

                $("#family").html(data.family);
                $("#micro").html(data.micro);

                if (type === 'vendor') {
                    $("#select-family .select2-container .select2-choice abbr").removeAttr('style');

                    if($("#s2id_family a").hasClass('select2-default'))
                        $("#select-family .select2-container .select2-choice abbr").hide();
                }
                else if(type === 'family'){
                    $("#select-micro .select2-container .select2-choice abbr").removeAttr('style');

                     if($("#s2id_micro a").hasClass('select2-default'))
                        $("#select-micro .select2-container .select2-choice abbr").hide();
                }
                // this enables the little cross to appear on the micro dropdown
                else if(type === 'micro'){
                    $("#select-micro .select2-container .select2-choice abbr").removeAttr('style');

                     if($("#s2id_micro a").hasClass('select2-default'))
                        $("#select-micro .select2-container .select2-choice abbr").hide();
                }




                if (type === 'vendor-removed'){
                    $("#select-family a").addClass('select2-default');
                    $("#select-family a span").html('All Families');
                }
                if (type === 'family-removed' || type === 'vendor-removed'){
                    $("#select-micro a").addClass('select2-default');
                    $("#select-micro a span").html('All MCUs');
                }
            },
            beforeSend: function() {
                if (type === 'vendor') {
                    $("#select-family .select2-container .select2-choice abbr").show();
                    $("#select-family .select2-container .select2-choice abbr").css("background", "url('assets/b9896ca8/select2-spinner.gif') no-repeat 100%, -moz-linear-gradient(center bottom, white 85%, #eeeeee 99%)");
                }
                else if (type === 'family') {
                    $("#select-micro .select2-container .select2-choice abbr").show();
                    $("#select-micro .select2-container .select2-choice abbr").css("background", "url('assets/b9896ca8/select2-spinner.gif') no-repeat 100%, -moz-linear-gradient(center bottom, white 85%, #eeeeee 99%)");
                }
            },
        });
    }

    ;

    function format(data) {
       //  console.log(data);
        // Using a custom formatResult will omit the underline under the matching characters
        return '<span class="label" style="margin-right: 15px" >5</span>' + data.text;
    }

</script>