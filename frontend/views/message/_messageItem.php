<div class="row-fluid">
	<div class="span1">
		<?php echo CHtml::image(Yii::app()->baseUrl().'/'.$message->sender->getProfileImageUrl(),$message->sender->username,array('width'=>32)); ?>
	</div>
	<div class="span11">
		<p>
			<?php echo $message->content; ?>
		</p>
		<div class="messageTime">
			<?php echo DateUtil::convertDate('d-m-Y H:i:s',$message->create_date); ?>
		</div>
	</div>
</div>