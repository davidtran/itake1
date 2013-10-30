<div class="row-fluid">

<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'farent-form',
        'enableAjaxValidation'=>true,
        'action'=>'postParentComment'
)); ?>
        <div class="row-fluid">
                <?php echo $form->hiddenField($model,'create_date',array('rows'=>3, 'class'=>'span12')); ?>
                <?php echo $form->hiddenField($model,'user_id',array('rows'=>3, 'class'=>'span12')); ?>
                <?php echo $form->hiddenField($model,'product_id',array('rows'=>3, 'class'=>'span12')); ?>
                <?php echo $form->hiddenField($model,'status',array('rows'=>3, 'class'=>'span12')); ?>
                <?php echo $form->hiddenField($model,'parent_id',array('rows'=>3, 'class'=>'span12')); ?>       
                <?php echo $form->textArea($model,'content',array('rows'=>3, 'class'=>'span12' )); ?>
                <?php echo $form->error($model,'content'); ?>
        </div>
        <div class="row-fluid buttons">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Reply' : 'Cập nhật',array('class'=>'pull-right btn btn-success' )); ?>
        </div>
<?php $this->endWidget(); ?>


</div>