<?php
/* @var $this CommentController */
/* @var $model Comment */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comment-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50, 'class' => 'span7')); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<!--<div class="row-fluid">-->
		<?php //echo $form->labelEx($model,'postId'); ?>
		<?php // echo $form->textField($model,'postId'); ?>
		<?php //echo $form->error($model,'postId'); ?>
	<!--</div>-->

        <div class="form-actions">
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'label' => $model->isNewRecord ? 'Create' : 'Save',
            ));
            ?>
        </div>

<?php $this->endWidget(); ?>

</div><!-- form -->