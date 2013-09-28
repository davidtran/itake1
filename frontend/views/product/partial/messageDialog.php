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
                <?php echo $form->hiddenField($message,'productId'); ?>
                <?php $this->widget('CCaptcha',array(
                                        'showRefreshButton'=>true,
                                        'buttonType'=>'button',
                                        'buttonOptions'=>
                                            array(
                                                'type'=>'image',
                                                'src'=>"/path/images/refresh-icon.png",
                                                'width'=>30,
                                                'id'=>'refreshCaptcha'
                                            ),                                                            
                                        'buttonLabel'=>'Reload')
                        ); ?>
                <br/>
                <?php echo CHtml::link('Gửi','#',array(
                    'class'=>'btnSendProductMessage btn btn-primary btn-large',
                    'data-product-id'=>$message->productId
                )); ?>
                <?php $this->endWidget(); ?>
                
            </div>
        </div>
    </div>
</div>
