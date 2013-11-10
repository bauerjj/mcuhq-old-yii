
<div class="main-title">
    <h1><?php echo $model->title; ?></h1>
</div>

<hr style="margin-top: 4px; margin-bottom: 4px;">

<div class="article">
    <?php
// MarkDown content
    $this->beginWidget('CMarkdown', array('purifyOutput' => true));
    echo $model->content;
    $this->endWidget();
    ?>
</div>