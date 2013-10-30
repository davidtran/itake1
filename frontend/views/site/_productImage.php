<div class="productImageContainer">
    <div class="productImageLink">
    
        <a target="_blank" href="<?php echo $product->getDetailUrl(); ?>" class="productLink"  title="<?php echo $product->description; ?>">
            <?php if (isset($product->firstImage)): ?>
                <?php
                echo CHtml::image(
                        Yii::app()->baseUrl . '/' . $product->firstImage->thumbnail, $product->title, array(
                    'class' => 'productImage',
                    'onError' => "this.onerror=null;this.src='http://www.placehold.it/300x300/EFEFEF/AAAAAA&text=Hình+SP';"
                        )
                );
                ?>   
            <?php else:?>
                <?php echo CHtml::image('http://www.placehold.it/400x400/EFEFEF/AAAAAA&text='.Yii::t('Default', 'Missing image'),$product->title,array(
                    'class'=>"productImage"
                ));?>
            <?php endif; ?>        
        </a>
    </div>
    <?php if($product->status==Product::STATUS_SOLD): ?>
    <div class="productSoldBg">
        <i class="icon-bookmark"></i>
    </div>
    <div class="productSoldWrapper">
        <div class="row-fluid">
            <span class="icon-stack icon-large">
                  <i class="icon-circle icon-stack-base"></i>
                  <i class="icon-flag icon-light"></i>
            </span>
            <div class="span12">
                <span class="center;">Đã bán</span>
            </div>
        </div>
    </div>
    <?php endif; ?>
     <div style="display:none" class="productControl">                        
            <div class="row-fluid" style="margin-top: 10px;">
                <?php
                Yii::beginProfile('GetImage'.$product->user->id); 
                    echo UserImageUtil::renderImage($product->user,array(
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
            <div class="row-fluid" style="margin-top: 10px;">
                <?php if($showControl):?>
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
                        if($product->status!=Product::STATUS_SOLD)
                        {
                            echo CHtml::link('<i class="icon-shopping-cart"></i> ' . LanguageUtil::t('Sold'), array('/upload/sold'), array(
                                'class' => 'btn btn-square p-sold',
                                'data-toggle' => 'tooltip',
                                'title' => 'Đã bán phẩm này',
                            ));
                        }
                        else{
                            echo CHtml::link('<i class="icon-remove"></i> ' . LanguageUtil::t('Remove'), array('/upload/delete'), array(
                                'class' => 'btn btn-square p-delete',
                                'data-toggle' => 'tooltip',
                                'title' => 'Xóa phẩm này',
                            ));
                        }
                        ?>             
                    <?php endif; ?>
                <?php endif; ?>
            </div> 

        </div>
</div>    