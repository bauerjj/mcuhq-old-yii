<div class="row-fluid">
        <div class="row-fluid">
            <div class="span12">
                <h4><?php echo CHtml::link(CHtml::encode($data->title), $data->url); ?></h4>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">
                <a href="#" class="thumbnail">
                    <img src="http://placehold.it/260x180" alt="">
                </a>
            </div>
            <div class="span10 article-preview">
                <p>
                    <?php
                    $this->beginWidget('CMarkdown', array('purifyOutput' => true));
                    echo strip_tags($data->content); // Strip tags gets ride of code tags
                    $this->endWidget();
                    ?>
                </p>
                <a href="#" class="btn  btn-mini">Read More <i class=" icon-chevron-right"></i></a>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <p></p>
                <p>
                    <i class="icon-user"></i> by <a href="#"><?php echo CHtml::encode($data->user->username) ?></a>
                    |  <span class="badge badge-success"><i class="icon-calendar "></i><?php echo date('F j, Y', strtotime($data->created)); ?></span>
                    | <i class="icon-comment"></i> <a href="#">3 Comments</a>
                    | <i class="icon-thumbs-up"></i> <span style="color: green">200</span>
                    <i class="icon-thumbs-down"></i> <span style="color: darkred">4</span>
                    | <i class="icon-tags"></i> <?php foreach ($data->tags as $tag)
                        echo '<a href="#"><span class="label label-info">' . CHtml::encode($tag->name) . '</span></a> ' ?>
                </p>
            </div>
        </div>
    </div>
<hr>







