<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'user-_formProfile-form',
	'enableAjaxValidation'=>false,
    'type'=>'vertical',
    'htmlOptions'=>array('class'=>'form itake-form','role'=>'form'),
)); ?>

	<!-- <p class="note">Fields with <span class="required">*</span> are required.</p>
 -->
    <fieldset>
	<?php echo $form->errorSummary($model); ?>
       <div class="row-fluid">
        <div class="span6">
            <div class="control-group">
    		    <?php echo $form->textFieldRow($model,'username',array('class'=>'controls','labelOptions'=>array('class'=>'control-label'))); ?>
            </div>            
            <div class="control-group">
                    <?php echo $form->labelEx($model,'birthday',array('class'=>'control-label')); ?>
                    <?php

            $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                'model'=>$model,
                'attribute'=>'birthday',
                'language'=>'vi',
                // additional javascript options for the date picker plugin
                'options'=>array(
                    'showAnim'=>'slide',
                    'changeMonth'=>true,
                    'changeYear'=>true,
                    'yearRange'=> '1980:+30',
                    'dateFormat' => 'dd-mm-yy',
                ),
                'htmlOptions'=>array(
                    'style'=>'height:20px;',
                    'class'=>'controls',
                    'value' => ($model->birthday) ? date('d-m-Y', strtotime($model->birthday)) : null,
                ),
            ));

             ?>
            </div>
            <div class="control-group">
    		    <?php echo $form->dropDownListRow($model,'city',  CityUtil::getCityListData(true),array('class'=>'controls','labelOptions'=>array('class'=>'control-label'))); ?>
            </div>
            <div class="control-group">
    		    <?php echo $form->textFieldRow($model,'locationText',array('class'=>'controls','labelOptions'=>array('class'=>'control-label'))); ?>
            </div>
            </div>
            <div class="span6">
            <div class="control-group">
    		    <?php echo $form->textFieldRow($model,'phone',array('class'=>'controls','labelOptions'=>array('class'=>'control-label'))); ?>
            </div>

            <div class="control-group">
    		    <?php echo $form->textAreaRow($model,'target',array('rows'=>3,'class'=>'controls','labelOptions'=>array('class'=>'control-label'))); ?>
            </div>
            <div class="control-group">
                <label class="control-label"><?php LanguageUtil::echoT('Password') ?></label>    
                <div class="controls"> 
                <?php echo CHtml::link(LanguageUtil::t('Change password'),$this->createUrl('user/changePassword'),array(
                            'class'=>'btn btn-primary',
                        )); ?>
                </div> 
            </div>
            </div>
        </div>
    <hr>
	<div class="control-group margin-top-20">
        <div class="controls">
		  <?php echo CHtml::submitButton(LanguageUtil::t('Update'),array('class' => 'btn btn-success btn-large')); ?>
          <?php if(isset($_GET['newUser']) && $_GET['newUser']) echo CHtml::link('Bỏ qua bước này',Yii::app()->createUrl('/site'),array('class' => 'btn btn-large')); ?>
        </div>
	</div>
    </fieldset>
<?php $this->endWidget(); ?>
<?php if(isset($_GET['newUser']) && $_GET['newUser']) : ?>
    <script type="text/javascript">
    $(document).on('ready',function(){
         showMessage('Cảm ơn bạn đã đăng ký tài khoản iTake. Để phục vụ bạn tốt nhất xin vui lòng cập nhật thông tin tài khoản. Hoặc bạn có thể bỏ qua bước này.',4000);
    });
       
    </script>
<?php  endif; ?>
<!-- form -->