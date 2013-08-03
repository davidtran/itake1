<div class="productItem <?php echo $product->category->getStyleName(); ?>" id="<?php echo $prefix?>product-<?php echo $product->id; ?>" data-product-id="<?php echo $product->id; ?>">
    <div class="row-fluid">
        <div class="product-detail">
            <?php echo $product->renderImageLink(); ?>            
            <div class="productImageInfo">
                <div class="productImageTitle"><?php echo StringUtil::limitCharacter(strtoupper($product->title), 25); ?></div>
                <hr class="sep_item"/>
                <div class="productImagePrice"><?php echo number_format($product->price,0); ?> đ</div>
             </div>
            <div class="productDescription">
                <?php echo StringUtil::limitCharacter($product->description, 50); ?>
            </div>
            <div class="productCreateDate">
                <?php 
                //echo DateUtil::convertDate('d-m-Y H:i:s', $product->create_date); 
                ?>                
                <?php echo $product->displayDateTime(); ?>                
                <?php
                $myUserModel = Yii::app()->user->getModel();
                if(isset($myUserModel)&&($myUserModel->id==$product->user_id)):?>
                    <div style="float:right;display:none" class="productControl">
                        <?php echo CHtml::link('<i class="icon-edit"></i>  Sửa',array('/upload/edit','id'=>$product->id),array(
                            'class'=>'btn flat p-edit',
                            'data-toggle'=>'tooltip',
                            'title'=>'Sửa thông tin sản phẩm',                            
                        ));?>
                        
                        <?php echo CHtml::link('<i class="icon-remove"></i> Đã bán ',array('/upload/delete'),array(
                            'class'=>'btn flat  p-delete',
                            'data-toggle'=>'tooltip',
                            'title'=>'Đã bán phẩm này',
                        )); ?>
                       
                        <script>
                            $('#p-edit').tooltip('show');
                            $('#p-delete').tooltip('show');
                        </script>
                    </div>
                <?php endif;?>
            </div>            
        </div>
        
    </div>
</div>