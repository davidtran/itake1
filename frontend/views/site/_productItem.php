<div class="productItem <?php echo $product->category->getStyleName(); ?>" 
     id="<?php echo $prefix ?>product-<?php echo $product->id; ?>" 
     data-product-id="<?php echo $product->id; ?>"
     data-title="<?php echo strip_tags($product->title); ?>">
    <div class="row-fluid">
        
            <?php echo Yii::app()->controller->renderPartial('/site/_productImage', array(
                    'product' => $product,
                    'showControl'=>$showControl
                        ), true, false); ?>         
        <div class="product-detail">
            <div class="productImageInfo">
                <div class="productImageTitle"><?php echo strtoupper($product->title); ?></div>
                <hr class="sep_item"/>
            </div>
            <div class="productDescription">
                <?php echo StringUtil::smartLimit(strip_tags($product->description),50); ?>
            </div>            
            <div class="productCreateDate">

                <div class="row-fluid">
                    <div class="span7">                                               
                        <div class="row-fluid">
                            <i class="icon-comments"></i> <span class="fb-comments-count" data-href='<?php echo ProductUtil::getCanonicalLink($product->id); ?>'/></span><br>
                            <?php echo $product->displayDateTime(); ?>  
                        </div>


                    </div>    
                    <div class="span5">
                        <div class="productImagePrice"><?php echo number_format($product->price, 0); ?> đ</div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="productItemDistance">
                        <?php
                        if(SolrSortTypeUtil::getInstance()->getCurrentSortType() == SolrSearchAdapter::TYPE_LOCATION){
                            $lat = UserLocationUtil::getInstance()->lat;
                            $lng = UserLocationUtil::getInstance()->lng;
                            if($lat && $lng){
                                ?>
                                <span class="icon-stack">
                                  <i class="icon-circle icon-stack-base"></i>
                                  <i class="icon-flag " style="color:graytext;"></i>
                                </span>
                                <?php
                                echo $product->getDistance($lat,$lng)." KM";
                            }
                        }
                        ?>
                    </div>
                </div>                
            </div>
            

        </div>
    </div>
</div>