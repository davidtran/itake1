<?php 
cs()->registerScriptFile(Yii::app()->baseUrl.'/js/app/message.js',CClientScript::POS_END); 
?>
<div id="messageDialog" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Gửi tin nhắn</h3>
  </div>
        <div class="modal-body">            
            
            
            <?php 
                $model = new Message();
                $model->receiver_id = $receiver->id;            
                $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array());
                echo PhihoFormSecurity::keyField('sendMessage'); 
            ?>    
            <?php echo $form->labelEx($model,'receiver_id'); ?>
            <span class=" uneditable-input" style="color:black;"><?php echo $receiver->username; ?></span>
        	<?php 
                echo $form->hiddenField($model,'receiver_id');
            ?>
        	<?php 
                echo $form->textAreaRow($model,'content',array('class'=>'span5'));
            ?>            	            	            	
            <?php 
                $this->endWidget();
            ?>
            
        </div>
        <div class="modal-footer">
            
            <a href="#" class="btn btn-primary" id="btnSendMessage"><i class="icon-ok icon-white"></i> Hoàn tất</a>            
            <a href="#" data-dismiss="modal" class="btn">Đóng</a>
            
        </div>
    
    </div>
</div>
