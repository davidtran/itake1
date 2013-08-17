<div class="row-fluid template-download uploaded-image  ">
    <div class="span12">
        <img src="<?php echo Yii::app()->baseUrl.'/'.$image->thumbnail; ?>" width="200">           
        <span class='delete'>
            <button class="btnDeleteImage" data-image-id="<?php echo $image->id; ?>">
                <i class="icon-trash"></i>                        
            </button>
            <input type="hidden" name="delete" value="1"> 
        </span>
    </div>
</div>