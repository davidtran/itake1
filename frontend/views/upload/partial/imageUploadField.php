<div class="fileupload fileupload-new" data-provides="fileupload">
    <?php echo $form->error($product,'image'); ?>
    <div class="fileupload-new thumbnail" style="max-width: <?php echo $size; ?>px; max-height: <?php echo $size; ?>x;">
        <?php if ($product->image == null): ?>
            <img src="http://www.placehold.it/300x300/EFEFEF/AAAAAA&text=<?php LanguageUtil::echoT('Click to select image') ?>"  style="max-width: <?php echo $size; ?>px; max-height: <?php echo $size; ?>px;"/>
        <?php else: ?>
            <?php
            echo CHtml::image(Yii::app()->baseUrl . '/' . $product->image, '', array(
                'id' => 'productImageHoder',
                'onError'=>"this.onerror=null;this.src='http://www.placehold.it/300x300/EFEFEF/AAAAAA&text=<?php LanguageUtil::echoT('Click to select image') ?>';"
            ));
            ?>
        <?php endif; ?>

    </div>
    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 200px; line-height: 20px;"></div>
    <div>
        <span class="btn btn-file">
            <span class="fileupload-new"><?php LanguageUtil::echoT('Upload from your computer') ?></span>
            <span class="fileupload-exists"><?php LanguageUtil::echoT('Change') ?></span>
            <input type="file" name="<?php echo $name; ?>" id='productImage'/></span>

        <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><?php LanguageUtil::echoT('Remove') ?></a>                                                                
    </div>
    
</div>