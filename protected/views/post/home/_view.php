<h1><?php echo $model->title; ?></h1>

<div class="article">
<?php
// MarkDown content
$this->beginWidget('CMarkdown', array('purifyOutput'=>true));
echo $model->content;
$this->endWidget();

?>
</div>