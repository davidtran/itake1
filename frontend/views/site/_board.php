<div id="productContainer" class="productBoard">
    <div class="grid-sizer"></div>
    <?php foreach($productList as $product):?>
        <?php if($product!==null)echo $product->renderHtml('home-'); ?>
    <?php endforeach; ?>
    
</div>
<?php echo $nextPageLink; ?>