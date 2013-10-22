<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comment-form',
	'enableAjaxValidation'=>true,
	'action'=>'postComment'
)); ?>
	<div class="row-fluid">
		<?php echo $form->textArea($model,'content',array('rows'=>3, 'class'=>'span12')); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>
	<div class="row-fluid buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Bình luận' : 'Cập nhật',array('class'=>'pull-right btn btn-success')); ?>
	</div>
<?php $this->endWidget(); ?>

</div>