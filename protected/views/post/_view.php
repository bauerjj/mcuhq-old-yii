<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('statusId')); ?>:</b>
	<?php echo CHtml::encode($data->status->status); // $data->statusId?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userId')); ?>:</b>
	<?php echo CHtml::encode($data->user->username); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('categoryId')); ?>:</b>
	<?php echo CHtml::encode($data->category->name); ?>
	<br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
	<?php echo CHtml::encode($data->created); ?>
	<br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('updated')); ?>:</b>
	<?php echo CHtml::encode($data->updated); ?>
	<br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('tags')); ?>:</b>
	<?php echo $data->getTags()?>
	<br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('content')); ?>:</b>
	<?php
        $this->beginWidget('CMarkdown');
        echo CHtml::encode($data->content);
        $this->endWidget();

        ?>
	<br />


</div>