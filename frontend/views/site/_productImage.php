<div class="productImageLink">
    <a target="_blank" href="<?php echo $product->getDetailUrl(); ?>" class="productLink" title="<?php echo $product->title; ?>">
        <?php if(isset($product->firstImage)):?>
        <?php echo CHtml::image(
                Yii::app()->baseUrl.'/'.$product->firstImage->thumbnail,
                $product->title,
                array(
                    'class'=>'productImage',
                    'onError'=>"this.onerror=null;this.src='http://www.placehold.it/300x300/EFEFEF/AAAAAA&text=Hình+SP';"
                )
         ); ?>        
     <?php endif; ?>
    </a>
</div>    