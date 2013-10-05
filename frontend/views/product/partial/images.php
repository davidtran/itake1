<div class="flexslider">
    <ul class="slides">
        <?php if($product->imageCount > 0):?>
            <?php foreach ($product->images as $image): ?>
                <li data-thumb="<?php echo Yii::app()->baseUrl . '/' . $image->thumbnail; ?>">
                    <div class='popup-gallery'>
                    <a class="image-popup-no-margins" href="<?php echo Yii::app()->baseUrl . '/' . $image->image; ?>"><img class="img-rounded" alt='<?php echo $product->title; ?>' src="<?php echo Yii::app()->baseUrl . '/' . $image->thumbnail; ?>" onError="this.onerror=null;this.src='http://www.placehold.it/400x400/EFEFEF/AAAAAA&text=<?php echo Yii::t('Default', 'Missing image'); ?>';"/>
                    </a>
                    </div>
                </li>
            <?php endforeach; ?>                
        <?php else:?>               
            <?php echo CHtml::image('http://www.placehold.it/400x400/EFEFEF/AAAAAA&text='.Yii::t('Default', 'Missing image'),$product->title,array(
                'class'=>"img-rounded"
            ));?>
        <?php endif; ?>
        
    </ul>
</div>
