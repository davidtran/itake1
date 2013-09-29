<div class="row-fluid">    
    <div class="modal hide fade" id='sendProductMessageDialog' style="top:50%;">        
        <div class="modal-body" > 
            <div class="row-fluid">
                <h3 class="intro_font center">
                	<span class="icon-stack">
					  <i class="icon-circle icon-stack-base"></i>
					  <i class="icon-comments icon-light"></i>
					</span>   
                	   Gửi tin nhắn cho <?php echo $message->receiver->username; ?>
                	</h3>
                
                <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                    'enableClientValidation'=>true,
                    'enableAjaxValidation'=>true,
                    'htmlOptions'=>array(                        
                        'id'=>'productMessageForm',
                        'class'=>'span11'
                    )
                )); ?>                
                <?php echo $form->textFieldRow($message,'senderName',array('class'=>'span12')); ?>
                <?php echo $form->textAreaRow($message,'message',array('class'=>'span12')); ?>
                <?php echo $form->textFieldRow($message,'captcha',array('class'=>'span12')); ?>
                <?php $this->widget('Captcha',array(                      
                        'clickableImage'=>true,                      
                        'imageOptions'=>array(
                            'id'=>'messageCaptchaImage'
                        )
                    )
                ); ?>
                <?php echo $form->hiddenField($message,'productId',array('class'=>'span12')); ?>
                <br/>
                <?php echo CHtml::link('<i class="icon-ok-sign"></i>  Gửi','#',array(
                    'class'=>'btnSendProductMessage btn btn-success btn-large flat pull-right',
                    'data-product-id'=>$message->productId
                )); ?>
                <?php $this->endWidget(); ?>
                
            </div>
        </div>
    </div>
</div>
