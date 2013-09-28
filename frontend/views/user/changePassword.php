<?php 
$this->pageTitle = LanguageUtil::t('Change password').' ITAKE';
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
        <?php if( $model->hideOldPassword == false):?>
            <?php echo $form->passwordFieldRow($model,'oldPassword',array(
            'placeholder'=> LanguageUtil::t('Old password'),
            'class'=>'input-block-level'
            )); ?>
        <?php else:?>
            <p>Nếu bạn đăng nhập từ Facebook và đây là lần đầu tiên đổi mật khẩu, thì bạn chỉ cần nhập mật khẩu mới. <br/>Mật khẩu này giúp bạn đăng nhập mỗi khi Facebook gặp sự cố.</p>
        <?php endif; ?>
        
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