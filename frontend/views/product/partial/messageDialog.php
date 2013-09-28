<div class="row-fluid">    
    <div class="modal" id='sendProductMessageDialog' style="top:50%;">        
        <div class="modal-body" > 
            <div class="row-fluid">
                <h3 class="intro_font center">
                	<span class="icon-stack">
					  <i class="icon-circle icon-stack-base"></i>
					  <i class="icon-shopping-cart icon-light"></i>
					</span>   
                	   Gửi tin nhắn cho <?php echo $message->receiver->username; ?>
                	</h3>
                
                <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                    'enableClientValidation'=>true,
                    'enableAjaxValidation'=>true,
                    'htmlOptions'=>array(                        
                        'id'=>'productMessageForm'
                    )
                )); ?>                
                <?php echo $form->textFieldRow($message,'senderName'); ?>
                <?php echo $form->textAreaRow($message,'message'); ?>
                
                <?php echo $form->textFieldRow($message,'captcha'); ?>
                <?php $this->widget('CCaptcha'); ?>
                <br/>
                <?php echo CHtml::link('Gửi','#',array(
                    'class'=>'btnSendProductMessage btn btn-primary btn-large'
                )); ?>
                <?php $this->endWidget(); ?>
                
            </div>
        </div>
    </div>
</div>
