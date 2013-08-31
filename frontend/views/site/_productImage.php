<div class="productImageLink">
    <a target="_blank" href="<?php echo $product->getDetailUrl(); ?>" class="productLink" title="<?php echo $product->title; ?>">
        <?php if (isset($product->firstImage)): ?>
            <?php
            echo CHtml::image(
                    Yii::app()->baseUrl . '/' . $product->firstImage->thumbnail, $product->title, array(
                'class' => 'productImage',
                'onError' => "this.onerror=null;this.src='http://www.placehold.it/300x300/EFEFEF/AAAAAA&text=Hình+SP';"
                    )
            );
            ?>        
        <?php endif; ?>
        <div style="display:none" class="productControl">                        
            <div class="row-fluid" style="margin-top: 10px;">
                
                <?php
                Yii::beginProfile('GetImage'.$product->user->id); 
                echo CHtml::image($product->user->getProfileImageUrl(), $product->user->username, array(
                    'width' => 30,
                    'height' => 30,
                    'style' => 'width: 30px;
                                      height: 30px;',
                    'class' => 'img-circle',
                ));
                Yii::endProfile('GetImage'.$product->user->id); 
                ?>      
            </div>                 
            <div class="row-fluid">
                <small class="center">            
                    <?php echo $product->user->username; ?> 
                </small>                                            
            </div>                           
            <div class="row-fluid">
                <?php
                $myUserModel = Yii::app()->user->getModel();
                if (isset($myUserModel) && ($myUserModel->id == $product->user_id)):
                    ?>
                    <?php
                    echo CHtml::link('<i class="icon-cog"></i>  ' . LanguageUtil::t('Edit'), array('/upload/edit', 'id' => $product->id), array(
                        'class' => 'btn btn-square p-edit',
                        'data-toggle' => 'tooltip',
                        'title' => 'Sửa thông tin sản phẩm',
                    ));
                    ?>

                    <?php
                    echo CHtml::link('<i class="icon-shopping-cart"></i> ' . LanguageUtil::t('Sold'), array('/upload/delete'), array(
                        'class' => 'btn btn-square p-delete',
                        'data-toggle' => 'tooltip',
                        'title' => 'Đã bán phẩm này',
                    ));
                    ?>             
<?php endif; ?>                            
            </div> 

        </div>  
    </a>     
</div>    