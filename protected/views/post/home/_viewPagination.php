<div class="row-fluid">
        <div class="row-fluid">
            <div class="span2">
                <a href="#" class="thumbnail">
                    <img src="http://placehold.it/260x180" alt="">
                </a>
            </div>
            <div class="span10 article-preview">
                <h4 style="margin-top: 4px; margin-bottom: 4px;"><?php echo CHtml::link(CHtml::encode($data->title), $data->url); ?></h4>
                <p>
                    <?php
                    $this->beginWidget('CMarkdown', array('purifyOutput' => true));
                    echo strip_tags($data->content); // Strip tags gets ride of code tags
                    $this->endWidget();
                    ?>
                </p>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <p></p>
                <p>
                    <a href="#"><?php echo CHtml::link(CHtml::encode($data->user->username),array('user/user/view','id'=>$data->user->id)) ?></a>
                    |  <?php echo date('F j, Y', strtotime($data->created)); ?>
                    | <?php echo CHtml::link($data->commentCount != 1 ? $data->commentCount . ' comments' : '1 comment'
                    , $data->url.'#comments') ?>
                    | <i class="fa fa-thumbs-o-down"></i> <span style="color: green">200</span>
                    <i class="fa fa-thumbs-o-up"></i> <span style="color: darkred">4</span>
                    |  <?php foreach ($data->tags as $tag)
                        echo '<a href="#"><span class="label label-info">' . CHtml::encode($tag->name) . '</span></a> ' ?>
                </p>
            </div>
        </div>
    </div>
<hr style="margin-top: 4px; margin-bottom: 4px;">







