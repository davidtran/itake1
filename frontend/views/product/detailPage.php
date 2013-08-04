<?php
$this->pageTitle = $product->title;
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.elevateZoom-2.5.5.min.js', CClientScript::POS_HEAD);
$this->addMetaProperty('og:title',$product->title); 
$this->addMetaProperty('og:description',StringUtil::limitByWord($product->description, 100));
$this->addMetaProperty('og:image',$product->image); 
$this->metaDescription = StringUtil::limitByWord($product->description, 100);
$this->metaKeywords = str_replace(' ',',',  strtolower(preg_replace('/[^0-9a-z\s]/', '', $product->title)));
?>
<div class="container-fluid" style="margin-top: 64px;">
    <div class="close_tag" style="top:45px;"> <a style="padding:20px;" class="close"  href="../../"><i class="icon-home"></i></a></div>
    <div id="detailProduct"style="display: block; margin-top: 0px;">                    
        <div id="detailProductBody" style="">
            <img class="ribbon" src="<?php echo Yii::app()->baseUrl;?>/images/ribbon.png">
            <p class="price"><?php echo number_format($product->price); ?></p>
            <div class="row-fluid">            
                <div class="productInfo">
                    <div class='span12 custom customtop' id="mainProductInfo">
                        <?php 
                            $this->widget('bootstrap.widgets.TbAlert', array(
                                'block'=>true,
                                'fade'=>true, 
                                'closeText'=>'×',
                                'alerts'=>array( 
                                    'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
                                ),
                            ));
                        ?>
                        <h1> <?php echo StringUtil::limitCharacter(strtoupper($product->title), 35); ?></h1>
                        <div class="row-fluid">                            
                            <div class="span6">
                                <div class="row-fluid">

                                    <?php echo CHtml::image(Yii::app()->baseUrl . '/' . $product->image_thumbnail,$product->title,array('data-zoom-image'=>Yii::app()->baseUrl . '/' . $product->image,'id'=>'imagePreview')); ?>

                               

                                </div>
                                <div class="row-fluid" style="margin-top: 20px;">
                                    <div class="fb-like" data-href="<?php echo $canonicalUrl; ?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div>
                                     <br/>
                                     <span class="badge" style="margin-bottom:10px;"><?php echo $product->view; ?> lượt xem</span>
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
                                                            <h4 class="product-detail-tag">Địa chỉ:  <?php echo CityUtil::getCityName($product->city); ?>    </h4> 
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
                    <div id="userProductList" style="display:none;">
                        <?php foreach ($userProductDataProvider->getData() as $userProduct): ?>
                            <?php echo $userProduct->renderHtml('home-user-'); ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>


        </div>
    </div></div>
    <script type="text/javascript" charset="utf-8" async defer>
        $(document).ready(function() {  
        $('#userProductList').imagesLoaded(function(){                              
                            masoryCenterAlign();
                            $('#userProductList').show('fade');
                            $('#userProductList').isotope('reLayout');
                            setTimeout(function() {
                                $('#userProductList').isotope('reLayout');
                             }, 200); 
                        });   
    });
    </script>