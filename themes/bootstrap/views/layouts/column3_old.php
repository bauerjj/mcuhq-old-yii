<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="row">
    <div class="span10">
        <div class="row">
        <div id="content" class="span8 pull-right">
            <?php echo $content; ?>
        </div><!-- content -->
        <div class="span2"><?php

        $this->widget('Categories', array(

        ));

        $this->widget('People', array(

        ));


        ?></div>
           </div><!-- end nested row -->
    </div><!-- end span9 -->

    <div class="span2">
        <div id="sidebar">
        <?php

        $this->widget('TagCloud', array(

        ));

        $this->widget('RecentTags', array(

        ));

            $this->beginWidget('zii.widgets.CPortlet', array(
                'title'=>'Operations',
            ));
            $this->widget('bootstrap.widgets.TbMenu', array(
                'items'=>$this->menu,
                'htmlOptions'=>array('class'=>'operations'),
            ));
            $this->endWidget();


        ?>
        </div><!-- sidebar -->
    </div>
</div>
<?php $this->endContent(); ?>