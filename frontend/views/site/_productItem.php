<div class="productItem <?php echo $product->category->getStyleName(); ?>" id="<?php echo $prefix?>product-<?php echo $product->id; ?>" data-product-id="<?php echo $product->id; ?>">
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

                <?php
                $myUserModel = Yii::app()->user->getModel();
                if(isset($myUserModel)&&($myUserModel->id==$product->user_id)):?>
                    <div style="float:right;display:none" class="productControl">
                        <?php echo CHtml::link('<i class="icon-edit"></i>',array('/upload/edit','id'=>$product->id),array(
                            'class'=>'btn flat p-edit',
                            'data-toggle'=>'tooltip',
                            'title'=>'Sửa thông tin sản phẩm',                            
                        ));?>
                        
                        <?php echo CHtml::link('<i class="icon-remove"></i>',array('/upload/delete'),array(
                            'class'=>'btn flat  p-delete',
                            'data-toggle'=>'tooltip',
                            'title'=>'Đã bán phẩm này',
                        )); ?>
                       
                        <script>
                            // $('#p-edit').tooltip('show');
                            // $('#p-delete').tooltip('show');
                        </script>
<?php endif; ?>
                    </div>
                    <div class="span6">
                          <div class="productImagePrice"><?php echo number_format($product->price,0); ?> đ</div>
                    </div>                    
            </div>                                                 
            </div>            
        </div>
        
    </div>
</div>
</div>