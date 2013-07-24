<?php
$this->pageTitle = 'Đăng nhập vào Nada';

//$this->showHeader = false;
?>


<?php
$this->widget('bootstrap.widgets.TbAlert', array(
    'block' => true,
    'fade' => true,
    'closeText' => '×',
    'alerts' => array(
        'error' => array('block' => true, 'fade' => true, 'closeText' => '×'),
    ),
));
?>
<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'type'=>'inline',
    'htmlOptions' => array(
        'class' => 'form-signin'
    )
));
?>
<?php 
$this->widget('bootstrap.widgets.TbAlert', array(
    'block'=>true, 
    'fade'=>true,
    'closeText'=>'×',
    'alerts'=>array( 
	    'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
    ),
));
	
?>
<h2 class="form-signin-heading">Đăng nhập</h2>          
<hr/>
<?php echo $form->errorSummary($model); ?>
<?php
echo $form->textFieldRow($model, 'username', array(
    'placeholder' => 'Địa chỉ email',
    'class' => 'input-block-level'
));
?>
<?php
echo $form->passwordFieldRow($model, 'password', array(
    'placeholder' => 'Mật khẩu',
    'class' => 'input-block-level'
));
?>
<?php //echo $form->checkBoxRow($model, 'rememberMe', array('value=1')); ?>
<div style="float:right;width:100%;text-align: right; font-size:0.9em;">
<?php echo CHtml::link('Quên mật khẩu ?', array('/user/forgetPassword')); ?>
</div>  
<div style="float:right;width:100%;">
<button class="btn btn-primary login" type="submit" style="width:100%;height:50px;font-size:1.3em;">Đăng nhập</button>
</div>
<div style="float:right;width:100%;">
    <hr/>
    <h4 class="rb-h4" style="text-align: center;">HOẶC ĐĂNG NHẬP BẰNG</h4>
<div class="fb-login-wrapper"> 
<?php echo CHtml::link('', FacebookUtil::makeFacebookLoginUrl($facebookRedirectUrl), array('class' => 'facebook-login')); ?>
    <!--<?php echo CHtml::link('', FacebookUtil::makeFacebookLoginUrl(), array('class' => 'google-login')); ?>-->
<!--    <span id="signinButton">
      <span
        class="g-signin"
        data-callback="signinCallback"
        data-clientid="933964749471.apps.googleusercontent.com"
        data-cookiepolicy="single_host_origin"
        data-requestvisibleactions="http://schemas.google.com/AddActivity"
        data-scope="https://www.googleapis.com/auth/plus.login">
      </span>
    </span>-->
<!--    <div id="gSignInWrapper">        
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