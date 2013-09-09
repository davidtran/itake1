<div class="productItem <?php echo $product->category->getStyleName(); ?>" id="<?php echo $prefix ?>product-<?php echo $product->id; ?>" data-product-id="<?php echo $product->id; ?>">
    <div class="row-fluid">
        <div class="product-detail">
            <?php echo $product->renderImageLink(); ?>            
            <div class="productImageInfo">
                <div class="productImageTitle"><?php echo StringUtil::limitCharacter(strtoupper($product->title), 25); ?></div>
                <hr class="sep_item"/>
            </div>
            <div class="productDescription">
                <?php echo StringUtil::limitCharacter($product->description, 50); ?>
            </div>            
            <div class="productCreateDate">

                <div class="row-fluid">
                    <div class="span6">                                               
                        <div class="row-fluid">
                            <?php echo $product->displayDateTime(); ?>  

                        </div>


                    </div>    
                    <div class="span6">
                        <div class="productImagePrice"><?php echo number_format($product->price, 0); ?> đ</div>
                        
                        <?php 
                            $lat = UserLocationUtil::getInstance()->lat;
                            $lng = UserLocationUtil::getInstance()->lng;
                            if($lat && $lng){
                                echo $product->getDistance($lat,$lng);
                            }
                        ?>
                        
                        
                    </div> 
                </div>            
            </div>

        </div>
    </div>
</div>