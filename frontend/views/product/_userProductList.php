<div id="userProductList" class="productBoard">
    <?php foreach($productList as $userProduct):?>
        <div class='imageProductItem'>
            <?php echo $userProduct->renderImageLink('dlg-'); ?>
        </div>
    <?php endforeach; ?>
</div>
<?php //echo CHtml::link('Next',array('/product/userProductList','id'=>$product->id,'page'=>$page+1),array('class'=>'nextUserProductListLink')); ?>