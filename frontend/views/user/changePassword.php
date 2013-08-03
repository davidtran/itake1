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
        <h2 class="form-signin-heading">Đổi mật khẩu</h2>
               
        <?php echo $form->errorSummary($model); ?>

        <?php echo $form->passwordFieldRow($model,'oldPassword',array(
        'placeholder'=>'Mật khẩu cũ',
        'class'=>'input-block-level'
        )); ?>
        
        <?php echo $form->passwordFieldRow($model,'password',array(
        'placeholder'=>'Mật khẩu mới',
        'class'=>'input-block-level'
        )); ?>
        
        <?php echo $form->passwordFieldRow($model,'retypePassword',array(
        'placeholder'=>'Nhập lại mật khẩu mới',
        'class'=>'input-block-level'
        )); ?>
      
        
        <button class="btn btn-primary btn-large pull-right" type="submit">Đổi mật khẩu</button>
        
     <?php $this->endWidget(); ?> 

</div>