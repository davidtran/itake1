<div class="productImageLink">
    <a target="_blank" href="<?php echo $product->getDetailUrl(); ?>" class="productLink" title="<?php echo $product->title; ?>">
        <?php echo CHtml::image(Yii::app()->baseUrl.'/'.$product->image_thumbnail,$product->title,array('class'=>'productImage')); ?>        
    </a>
</div>    