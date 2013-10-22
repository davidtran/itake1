<div class="productItem <?php echo $product->category->getStyleName(); ?>" 
     id="<?php echo $prefix ?>product-<?php echo $product->id; ?>" 
     data-product-id="<?php echo $product->id; ?>"
     data-title="<?php echo $product->title; ?>">
    <div class="row-fluid">
        <div class="product-detail">
            <?php echo Yii::app()->controller->renderPartial('/site/_productImage', array(
                    'product' => $product,
                    'showControl'=>$showControl
                        ), true, false); ?>            
            <div class="productImageInfo">
                <div class="productImageTitle"><?php echo strtoupper($product->title); ?></div>
                <hr class="sep_item"/>
            </div>
            <div class="productDescription">
                <?php echo StringUtil::smartLimit(strip_tags($product->description),50); ?>
            </div>            
            <div class="productCreateDate">

                <div class="row-fluid">
                    <div class="span8">                                               
                        <div class="row-fluid">
                            <?php echo $product->displayDateTime(); ?>  

                        </div>


                    </div>    
                    <div class="span4">
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
                <div class="row-fluid">
                    <div class="span12">
                        <fb:comments-count href='<?php echo $product->getDetailUrl(true); ?>'/></fb:comments-count> <i class="icon-comments"></i>
                    </div>
                </div>
            </div>
            

        </div>
    </div>
</div>