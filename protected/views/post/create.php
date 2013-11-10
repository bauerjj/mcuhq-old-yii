<?php
$this->breadcrumbs=array(
	'Posts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Post','url'=>array('index')),
	array('label'=>'Manage Post','url'=>array('admin')),
);
?>

<div class ="main-title">
<h1>Submit Content</h1>
</div> 

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>