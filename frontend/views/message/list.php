<div class="row">
	<div class="span12">
		<h1>Tin nhắn của bạn</h1>
	</div>
</div>
<div class='row'>
	<div class="span8">
		<?php $this->widget('bootstrap.widgets.TbGridView',array(
			'dataProvider'=>$dataProvider,
			'summaryText'=>'',			
			'columns'=>array(
				//image, ten, noi dung cuoi cung, ngay gui
				array(
					'header'=>'Người gửi',
					'type'=>'raw',
					'value'=>'CHtml::image(UserUtil::getProfileImageUrl($data),$data->username,array("width"=>20))'
				),
				array(
					'header'=>'Người gửi',
					'type'=>'raw',
					'value'=>'UserUtil::makeUserProfileLink($data)'
				),
				array(
					'value'=>'$data->lastMessageContent',
					'header'=>'Nội dung'
				),
				array(
					'value'=>'DateUtil::convertDate("d-m-Y H:i:s",$data->lastMessageDate)',
					'header'=>'Ngày gửi',
				),
				array(
					'class'=>'bootstrap.widgets.TbButtonColumn',
					'template'=>'{view}',
					'viewButtonUrl'=>'Yii::app()->controller->createUrl("/message/conversation",array("friend_id"=>$data->id))'
				)
			)
		)); ?>
	</div>
</div>

