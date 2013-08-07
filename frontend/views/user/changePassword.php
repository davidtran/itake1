<?php 
$this->pageTitle = 'Đổi mật khẩu tài khoản tại ListenToMe.vn';
//$this->showHeader = false;
?>

<div class="container more-space" style="margin-top:54px;">
    <?php 

    $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, 
        'fade'=>true, 
        'closeText'=>'×',
        'alerts'=>array( 
            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), 
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), 
        ),
    ));
    ?>
    <?php $form= $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    	'htmlOptions'=>array(
    		'class'=>'form-signin'
    	)
    ));?>
        <h2 class="form-signin-heading"><?php  LanguageUtil::echoT('Change password')?> </h2>
               
        <?php echo $form->errorSummary($model); ?>

        <?php echo $form->passwordFieldRow($model,'oldPassword',array(
        'placeholder'=> LanguageUtil::t('Old password'),
        'class'=>'input-block-level'
        )); ?>
        
        <?php echo $form->passwordFieldRow($model,'password',array(
        'placeholder'=>LanguageUtil::t('New password'),
        'class'=>'input-block-level'
        )); ?>
        
        <?php echo $form->passwordFieldRow($model,'retypePassword',array(
        'placeholder'=>LanguageUtil::t('Reconfirm new password'),
        'class'=>'input-block-level'
        )); ?>
      
        
        <button class="btn btn-primary btn-large pull-right" type="submit"><?php LanguageUtil::echoT('Update') ?></button>
        
     <?php $this->endWidget(); ?> 

</div>