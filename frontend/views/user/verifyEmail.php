<div class="container-fluid " style="margin-top:44px;">
	<div class="span12">
		<?php if(true == $result):?>
			Xác thực tài khoản thành công. <?php echo CHtml::link('Quay về trang chủ.','/site'); ?>
		<?php else:?>
			Không thể xác thực, thông tin có thể bị quá hạn hoặc mã xác thực không chính xác. 
			<?php echo CHtml::link('Gửi lại',array('/user/verifyEmail'),array(
				'class'=>'btn btn-lg btn-primary'
			)); ?>
		<?php endif;?>
	</div>
</div>