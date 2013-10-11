<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'user-_formProfile-form',
	'enableAjaxValidation'=>false,
)); ?>

	<!-- <p class="note">Fields with <span class="required">*</span> are required.</p>
 -->
	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->textFieldRow($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->textFieldRow($model,'username'); ?>
	</div>

	<div class="row">
		 <?php echo $form->datepickerRow(
            $model,
            'birthday',
            array(
                'options' => array('format' => 'dd/mm/yyyy' , 'weekStart'=> 1),
                'prepend' => '<i class="icon-calendar"></i>'
            )
        ); ?>
	</div>


	<div class="row">
		<?php echo $form->textFieldRow($model,'locationText'); ?>
	</div>
	<div class="row">
		<?php echo $form->textFieldRow($model,'phone'); ?>
	</div>
	<div class="row">
		<?php echo $form->textFieldRow($model,'target'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(LanguageUtil::t('Update'),array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->