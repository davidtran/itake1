<?php
$this->pageTitle = 'Quên mật khẩu';

//$this->showHeader = false;
?>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'htmlOptions' => array(
        'class' => 'form-signin'
    )
));
?>

<h2 class="form-signin-heading">Quên mật khẩu</h2>  
<hr/>
<p></p>
<?php echo $form->errorSummary($model); ?>
<?php
echo $form->textFieldRow($model, 'email', array(
    'placeholder' => 'Nhập vào địa chỉ email của bạn',
    'class' => 'input-block-level'
));
?>
<?php
$this->widget('CCaptcha');
echo $form->textFieldRow($model,'captcha',array(
    'placeholder' => 'Nhập vào những chữ ở trên để xác nhận',
    'class' => 'input-block-level'
));
?>

<hr/>
<button class="btn btn-primary login" type="submit">Gửi</button>

<br/>
<br/>

<?php $this->endWidget(); ?> 

