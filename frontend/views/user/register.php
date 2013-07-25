<?php
$this->pageTitle = 'Tạo tài khoản vào '.Yii::app()->name;

//$this->showHeader = false;
?>


<div class="container-fluid" style="margin-top: 74px;">
    <div class="row-fluid">
        <div class="span4 login-panel offset4">
<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'type'=>'inline',
    'htmlOptions' => array(
        'class' => 'form-signin'
    )
));
?>
<h2 class="form-signin-heading"><i class="icon-group"></i>  Gia nhập itake</h2>  
<hr/>
<?php
$this->widget('bootstrap.widgets.TbAlert', array(
    'block' => true,
    'fade' => true,
    'closeText' => '×',
    'alerts' => array(
        'success' => array('block' => true, 'fade' => true, 'closeText' => '×'),
    ),
));
?>      
<?php echo $form->errorSummary($user); ?>
<?php echo $form->textFieldRow($user,'email',array(
    'placeholder'=>'Địa chỉ email',
    'class'=>'input-block-level'
)); ?>
<?php
echo $form->textFieldRow($user, 'username', array(
    'placeholder' => 'Tên của bạn',
    'class' => 'input-block-level'
));
?>
<?php
echo $form->passwordFieldRow($user, 'password', array(
    'placeholder' => 'Mật khẩu',
    'class' => 'input-block-level'
));
?>
<button class="btn btn-success login" type="submit" style="width:100%;height:50px;font-size:1.3em;">Tạo tài khoản</button>
<br/>
<div style="float:right;width:100%;">
<hr/>
<h4 class="rb-h4" style="text-align: center;">HOẶC ĐĂNG KÝ BẰNG</h4>
<div class="fb-login-wrapper"> 
<?php echo CHtml::link('', FacebookUtil::makeFacebookLoginUrl($this->createAbsoluteUrl('register')), array('class' => 'facebook-login')); ?>
<!--  <div id="gSignInWrapper">        
        <div id="gplusSignIn" class="customGPlusSignIn">
            <span class="icon"></span>
            <span class="buttonText"></span>
        </div>
    </div>-->
</div>     
</div>
<?php $this->endWidget(); ?> 

<style>
    #gplusSignIn {
      display: inline-block;      
      color: white;
      width: 350px;      
      height: 77px;
      cursor: pointer;
      background: url('../images/gplus_btn.png') no-repeat;
      white-space: nowrap;
    }
    #customBtn:hover {
      background: #e74b37;
      cursor: hand;
    }
    span.label {
      font-weight: bold;
    }
    span.icon {      
      display: inline-block;
      vertical-align: middle;
      width: 35px;
      height: 35px;      
    } 
</style>
 </div>        
    </div>
</div>