<div class="row-fluid uploaded-image">
    <div class="span12">
        <img src="<?php echo $image->thumbnail; ?>" width="200">           
        <span class='delete'>
            <button class='' class="btnDeleteImage" data-image-id="<?php echo $image->id; ?>">
                <i class="icon-trash"></i>                        
            </button>
            <input type="hidden" name="delete" value="1"> 
        </span>
    </div>
</div>