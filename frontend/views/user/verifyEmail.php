<?php
$this->pageTitle = 'Xác thực email';
?>

<?php if(false == $verifyResult):?>
	Rất tiếc chúng tôi không thể xác thực email của bạn.
	Click vào đây để gửi lại email xác thực.
	<?php echo CHtml::link('Gửi email xác thực','/user/sendVerifyEmail',array(
	    'class'=>'btn btn-primary'
	)); ?>
<?php else:?>
	<div class='alert alert-success'>

		<p>Chúc mừng bạn đã xác thực email thành công :)</p>
		<br/>
		<?php if(Yii::app()->user->isGuest):?>

			<?php echo CHtml::link('Đăng nhập vào ListenToMe.vn','/user/login',array(
			    'class'=>'btn btn-primary btn-success'
			)); ?>

		<?php else:?>

			<?php echo CHtml::link('Quay về trang chủ','/site',array(
			    'class'=>'btn btn-primary btn-success'
			)); ?>

		<?php endif; ?>

	</div>
<?php endif; ?>