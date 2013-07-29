<?php 
$this->pageTitle = $product->title; 
?>
<img class="ribbon" src="<?php echo Yii::app()->baseUrl;?>/images/ribbon.png">
<p class="price"><?php echo number_format($product->price); ?></p>
<div class="row-fluid">
    <div class="productInfo">
                    <div class='span12 custom customtop' id="mainProductInfo">

                        <h1> <?php echo StringUtil::limitCharacter(strtoupper($product->title), 35); ?></h1>
                        <div class="row-fluid">                            
                            <div class="span6">
                                <div class="row-fluid">
                                    <?php echo CHtml::image(Yii::app()->baseUrl . '/' . $product->image,$product->title,array('data-zoom-image'=>Yii::app()->baseUrl . '/' . $product->image,'id'=>'imagePreview')); ?>
                                </div>
                                <div class="row-fluid" style="margin-top: 20px;">
                                     <span class="badge" style="margin-bottom:10px;"><?php echo $product->view; ?>lượt xem</span>
                                     <!-- AddThis Button BEGIN -->
                                    <div class="addthis_toolbox addthis_default_style">
                                    <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                                    <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
                                    <a class="addthis_button_tweet"></a>
                                    <a class="addthis_button_pinterest_pinit"></a>
                                    </div>
                                    <script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
                                    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5165a11f04e5f961"></script>
                                    <!-- AddThis Button END -->
                                </div>                                   
                            </div>
                            <div class="span6 custom">
                                <div class="row-fluid">
                                    <div class="bs-docs-example">
                                        <ul id="myTab" class="nav nav-tabs">
                                            <li class="active"><a href="#thongtinchung" data-toggle="tab"><i class="icon-tags"></i> Thông tin chung</a></li>
                                            <li class=""><a id='btnShowMap' href="#bando" data-toggle="tab"><i class="icon-map-marker"></i>  Bản đồ</a></li>                              
                                        </ul>
                                        <div id="myTabContent" class="tab-content">
                                            <div class="tab-pane fade active in" id="thongtinchung">
                                                <div class="row-fluid">
                                                    <div class="span6">
                                                    <h4 class="product-detail-tag">Giá</h4>
                                                    <span><i class="icon-money"></i>  <?php echo number_format($product->price); ?> VNĐ<br/></span>
                                                    </div>
                                                    <div class="span6">
                                                        <h4 class="product-detail-tag">Người bán</h4>
                                                        <i class="icon-user"></i>  <?php echo $product->user->getUserProfileLink(); ?><br/>
                                                    </div>
                                                </div>                                                
                                                <div class="row-fluid">
                                                    <div class="span6">
                                                    <h4 class="product-detail-tag"> Số điện thoại</h4>
                                                    <i class="icon-phone-sign"></i> <?php echo $product->phone; ?><br/>
                                                    </div>
                                                    <div class="span6">
                                                        <h4 class="product-detail-tag">Ngày đăng</h4>
                                                        <i class="icon-calendar"></i>  <?php echo DateUtil::convertDate('d-m-Y H:i:s', $product->create_date); ?>
                                                    </div>
                                                </div>  
                                                <?php if ($product->lat != null && $product->lon != null): ?>
                                                    <div class="row-fluid">                                                                                                                                                        
                                                                                              
                                                        <?php if (trim($product->locationText) != ''): ?>
                                                            <h4 class="product-detail-tag">Địa chỉ:</h4> 
                                                            <?php echo $product->locationText ; ?>                    
                                                        <?php endif; ?>                                         
                                                        
                                                    </div>
                                                <?php endif; ?>
                                                 <div class="row-fluid">     
                                                     <div class="span12">
                                                    <h4 class="product-detail-tag"> Mô tả sản phẩm</h4>
                                                    <div class="slim-scroll" data-height="150">
                                                        <?php echo $product->description; ?>
                                                    </div>   
                                                    </div>
                                                 </div>
                                            </div>
                                            <div class="tab-pane fade" id="bando">                                                  
                                                <?php if ($product->lat != null && $product->lon != null): ?>
                                                    <div class="row-fluid">                                                                                                                                                        
                                                        <h4 class="product-detail-tag">Thành phố <?php echo CityUtil::getCityName($product->city); ?></h4>                                        
                                                                                           
                                                        <div id='map'></div>  
                                                        <script>
                                                            $('a[href="#bando"]').on('shown', function (e) {  
                                                               loadProductMap(currentProduct);
                                                            })                    
                                                        </script>
                                                    </div>
                                                <?php endif; ?>
                                            </div>                                  
                                        </div>
                                    </div>
                                </div>                                                           
                              
                            </div>                
                        </div>  


                    </div>

                </div>
    
</div>
<div class="row-fluid">
    <div class="span12 custom">
        <h3>Thảo luận</h3>
        <hr/>
        <div class="fb-comments" data-href="<?php echo $canonicalUrl; ?>" data-width="" data-num-posts="10"></div>
    </div>
</div>
<div class="row-fluid">
    <div class="span12 custom">
        <h3>Cùng người đăng</h3>
        <hr/>
        <div id="userProductList">
            <?php foreach($userProductDataProvider->getData() as $userProduct):?>
                <?php echo $userProduct->renderHtml('dlg-user-'); ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
