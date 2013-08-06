<div class="row-fluid">    
    <div class="modal" id='feedbackDialog' style="top:20%;">    

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel"><i class="icon-comments-alt"></i>    <?php LanguageUtil::echoT('Feedback') ?></h3>
  </div>
        <div class="modal-body">            
            <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                'enableClientValidation'=>true,
                'enableAjaxValidation'=>true,
                'htmlOptions'=>array(
                    'action'=>$this->createUrl('validate'),
                    'id'=>'feedbackForm'
                )
            ));?>
                <?php echo $form->textFieldRow($feedback,'username'); ?>
                <?php echo $form->textFieldRow($feedback,'email'); ?>
                <?php echo $form->textAreaRow($feedback,'message'); ?>                                      
            <?php $this->endWidget(); ?>
        </div>
        <div class="modal-footer">
            
            <?php echo CHtml::link(LanguageUtil::t('Send'),'#',array(
                'class'=>'btn btn-success',
                'data-loading-text'=>LanguageUtil::t('Sending').'...',
                'id'=>'btnSendFeedback'
            ));?>
            <a href="#" data-dismiss="modal" class="btn"><?php LanguageUtil::echoT('Close') ?></a>
            
        </div>
    
    </div>
</div>
