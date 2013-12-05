<div class="row-fluid">    
    <div class="modal hide fade" id='slugDialog' style="top:20%;">    

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Chọn địa chỉ cho trang cá nhân của bạn</h3>
  </div>
        <div class="modal-body">            
            <p>Hãy chọn địa chỉ cho trang cá nhân của bạn.<br/>
Chỉ được sử dụng tiếng Việt không dấu, số và dấu gạch ngang. Bạn chỉ được chọn một lần duy nhất.</p>
            <p>
                Ví dụ http://itake.me/<b><span id="newSlug"><?php echo $defaultSlug; ?></span></b>
            </p>
            <?php echo CHtml::textField('slug',''); ?>
        </div>
        <div class="modal-footer">
            
            <?php echo CHtml::link('Lưu lại','#',array(
                'class'=>'btn btn-success',                
                'id'=>'btnSaveSlug'
            ));?>
            <a href="#" data-dismiss="modal" class="btn"><?php LanguageUtil::echoT('Close') ?></a>
            
        </div>
    
    </div>
</div>
