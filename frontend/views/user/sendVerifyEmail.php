<?php 
$this->pageTitle = 'Xác thực địa chỉ email';
?>
<div class="container-fluid" style="margin-top: 24px;">
	<div class='row-fluid'>
		<div class='span6 offset3'>
			<h1>Xác thực địa chỉ email</h1>
			<?php if($success):?>
				<p class='alert alert-success'>
					Email xác thực đã được gử đến địa chỉ <?php echo $model->email; ?>. Vui lòng kiểm tra hộp thư của bạn.
					<br/>
					<?php echo CHtml::link('Quay về trang chủ',array('/site/home')); ?>
				</p>
			<?php endif; ?>
			<p>Hãy nhập địa chỉ email bạn muốn gửi email xác thực. Thay đổi email nếu bạn nhập sai email.</p>
			<?php 
			$form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array());
			?>
			<?php echo $form->errorSummary($model); ?>
			<div class='form-group'>
				<?php echo $form->textFieldRow($model,'email',array(
					'class'=>'form-control',
					'value'=>$user->email
				)); ?>
			</div>
			<?php echo CHtml::submitButton('Xác thực',array(
				'class'=>'btn btn-primary'
			)); ?>
			<?php $this->endWidget(); ?>
		</div>
	</div>
</div>
