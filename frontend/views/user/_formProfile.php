<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'user-_formProfile-form',
	'enableAjaxValidation'=>false,
    'type'=>'vertical',
    'htmlOptions'=>array('class'=>'form','role'=>'form'),
)); ?>

	<!-- <p class="note">Fields with <span class="required">*</span> are required.</p>
 -->
    <fieldset>
	<?php echo $form->errorSummary($model); ?>
        <div class="control-group">
		    <?php echo $form->textFieldRow($model,'email',array('disabled'=>true,'class'=>'controls','labelOptions'=>array('class'=>'control-label'))); ?>
        </div>
        <div class="control-group">
		    <?php echo $form->textFieldRow($model,'username',array('class'=>'controls','labelOptions'=>array('class'=>'control-label'))); ?>
        </div>
        <div class="control-group">
		 <?php echo $form->datepickerRow(
            $model,
            'birthday',
            array(
                'options' => array('format' => 'dd/mm/yyyy' , 'weekStart'=> 1),
                'class'=>'controls',
                'labelOptions'=>array('class'=>'control-label'),
                'prependOptions'=>array('class'=>'span2')
            )
        ); ?>
        </div>

        <div class="control-group">
		    <?php echo $form->textFieldRow($model,'locationText',array('class'=>'controls','labelOptions'=>array('class'=>'control-label'))); ?>
        </div>

        <div class="control-group">
		    <?php echo $form->textFieldRow($model,'phone',array('class'=>'controls','labelOptions'=>array('class'=>'control-label'))); ?>
        </div>

        <div class="control-group">
		    <?php echo $form->textAreaRow($model,'target',array('rows'=>3,'class'=>'controls','labelOptions'=>array('class'=>'control-label'))); ?>
         </div>

	<div class="buttons">
		<?php echo CHtml::submitButton(LanguageUtil::t('Update'),array('class' => 'btn btn-success')); ?>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>

<!-- form -->