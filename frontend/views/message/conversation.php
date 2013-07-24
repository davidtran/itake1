<?php 
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/app/message.js',CClientScript::POS_END); ?>
?>
<div class="row">
	<div class="span12">
		<h1>Nhắn tin cho <?php echo $friend->username; ?></h1>
	</div>
</div>
<div class='row'>
	<div class="span8">
		<div id="messageContainer">
			<div id="messageList">
				<?php foreach($messageList as $message):?>
					<?php echo $this->renderPartial('/message/_messageItem',array('message'=>$message)); ?>
				<?php endforeach; ?>
			</div>
			<div id="sendContainer">
				<?php $form= $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
					'enableClientValidation'=>true,
					'id'=>'conversationMessageForm'
				)); ?>
					<?php echo PhihoFormSecurity::keyField('sendMessage'); ?>
					<?php echo $form->hiddenField($newMessage,'receiver_id'); ?>
					<div class="row-fluid">
						<div class='span10'>						
							<?php echo $form->textAreaRow($newMessage,'content'); ?>
						</div>
						<div class='span2'>
							<?php echo CHtml::link('Gửi','#',array(
								'class'=>"btn btn-primary",
								'id'=>'btnSendConversationMessage'
							)); ?>
						</div>
					</div>
				<?php $this->endWidget(); ?>

			</div>
		</div>
	</div>
</div>

