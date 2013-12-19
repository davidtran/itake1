<div class="form">
<?php
$model = new Comment ;
$model->product_id = (int)$product->id;
?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comment-form',
	'enableAjaxValidation'=>true,
	'action'=>'postComment'
)); ?>
	<div class="row-fluid">
		<?php echo $form->hiddenField($model,'create_date',array('rows'=>3, 'class'=>'span12')); ?>
		<?php echo $form->hiddenField($model,'user_id',array('rows'=>3, 'class'=>'span12')); ?>
		<?php echo $form->hiddenField($model,'product_id',array('rows'=>3, 'class'=>'span12')); ?>
		<?php echo $form->hiddenField($model,'status',array('rows'=>3, 'class'=>'span12')); ?>
		<?php echo $form->hiddenField($model,'parent_id',array('rows'=>3, 'class'=>'span12')); ?>
		<?php echo $form->textArea($model,'content',array(
                'rows'=>3, 
                'class'=>'span12',
                'id'=>'fb_message',
                'placeholder'=>Yii::t('Default','Login to comment')
            )
        ); ?>
		<?php echo $form->error($model,'content'); ?>
        <?php echo CHtml::hiddenField('loginUrl',
                $this->createUrl('/user/login',array('returnUrl'=>$model->product->getDetailUrl())),
                array('class'=>'commentLoginUrl')); ?>
	</div>
	<label class="checkbox">
      <input type="checkbox" id="post2facebook" checked="checked"> Post to Facebook
    </label>
	<div class="row-fluid buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Bình luận' : 'Cập nhật',array('class'=>'pull-right btn btn-success')); ?>
	</div>
	<div id="fb-root"></div>
<?php $this->endWidget(); ?>
</div>