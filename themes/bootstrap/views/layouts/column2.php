<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="container-fluid fill">
    <div class="row-fluid">
        <div class="fixed-sidebar">
            <?php

            if (isset($this->clips['quickLinks'])) {

                echo $this->clips['quickLinks'];
            }


            if (isset($this->clips['articleInfo'])) {

                echo $this->clips['articleInfo'];
            }


            $this->widget('Categories', array(
            ));

            $this->widget('People', array(
            ));

            $this->widget('TagCloud', array(
            ));

            $this->widget('RecentTags', array(
            ));
            ?>
            <?php
            $this->beginWidget('bootstrap.widgets.TbBox', array(
                'title' => 'Operations',
            ));
            $this->widget('bootstrap.widgets.TbMenu', array(
                'items' => $this->menu,
                'htmlOptions' => array('class' => 'operations'),
            ));
            $this->endWidget();
            ?>
        </div><!-- sidebar -->
        <div class="content-column">
            <div id="content">
                <?php echo $content; ?>
            </div><!-- content -->
        </div>
    </div>
</div>
<?php $this->endContent(); ?>
