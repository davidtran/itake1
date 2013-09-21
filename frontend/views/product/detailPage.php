<?php
$this->pageTitle = $product->title;
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.elevateZoom-2.5.5.min.js', CClientScript::POS_HEAD);

?>

<div class="row-fluid"  style="margin-top: 64px;">
    
        <div class="close_tag" style="top:45px;"> 
            <a style="padding:20px;" class="close"  href="../../"><i class="icon-home"></i></a></div>
        <div id="detailProduct"style="display: block; margin-top: 0px;">                    
            <div id="detailProductBody" style="">
                <div id="productDialogBody">
                <div class="row-fluid">            
                    <div class="productInfo">
                        <div class='span12 custom customtop' id="mainProductInfo">
                            <?php
                            $this->widget('bootstrap.widgets.TbAlert', array(
                                'block' => true,
                                'fade' => true,
                                'closeText' => '×',
                                'alerts' => array(
                                    'success' => array('block' => true, 'fade' => true, 'closeText' => '×'), // success, info, warning, error or danger
                                ),
                            ));
                            ?>
                            <h1> <?php echo StringUtil::limitCharacter(strtoupper($product->title), 100); ?></h1>
                            <div class="row-fluid">                            
                                <div class="span6">
                                    <div class="row-fluid">
                                        
                                        <?php $this->renderPartial('partial/images',array(
                                            'product'=>$product
                                        )); ?>



                                    </div>
                                    <div class="row-fluid" style="margin-top: 20px;">
                                        <div class="fb-like" href="<?php echo $canonicalUrl; ?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div>
                                    </div>
                                    <div class="row-fluid" style=" margin-top: 30px; ">
                        <span class="" style="margin-bottom:10px;color:#005580;font-size:0.9em;"> <i class="icon-eye-open"></i>
                            <?php echo Yii::t('Default','{number} view|{number} views',array($product->view,'{number}'=>$product->view));   ?></span>
                                    </div>
                                </div>
                                <div class="span6 custom">
                                    <div class="row-fluid">
                                        <div class="bs-docs-example">
                                            <ul id="myTab" class="nav nav-tabs">
                                                <li class="active"><a href="#thongtinchung" data-toggle="tab"><i class="icon-tags"></i> <?php LanguageUtil::echoT('General info') ?></a></li>
                                                <li class=""><a id='btnShowMap' href="#bando" data-toggle="tab"><i class="icon-map-marker"></i>  <?php LanguageUtil::echoT('Map') ?></a></li>                              
                                            </ul>
                                            <div id="myTabContent" class="tab-content">
                                                <div class="tab-pane fade active in" id="thongtinchung">
                                                    <div class="row-fluid">
                                                        <div class="span6">
                                            			<h4 class="product-detail-tag"><?php LanguageUtil::echoT('Price') ?></h4>
                                                            <span><i class="icon-money"></i>  <?php echo number_format($product->price); ?> VNĐ<br/></span>
                                                        </div>
                                                        <div class="span6">
                                            <h4 class="product-detail-tag"><?php LanguageUtil::echoT('Seller') ?></h4>
                                                            <i class="icon-user"></i>  <?php echo $product->user->getUserProfileLink(); ?><br/>
                                                        </div>
                                                    </div>                                                
                                                    <div class="row-fluid">
                                                        <div class="span6">
                                            <h4 class="product-detail-tag"> <?php LanguageUtil::echoT('Phone') ?></h4>
                                                            <i class="icon-phone-sign"></i> <?php echo $product->phone; ?><br/>
                                                        </div>
                                                        <div class="span6">
                                            <h4 class="product-detail-tag"><?php LanguageUtil::echoT('Date') ?></h4>
                                                            <i class="icon-calendar"></i>  <?php echo DateUtil::convertDate('d-m-Y H:i:s', $product->create_date); ?>
                                                        </div>
                                                    </div>  
                                                    <?php if ($product->address->lat != null && $product->address->lon != null): ?>
                                                        <div class="row-fluid">

                                                            <?php if (trim($product->address->address) != ''): ?>
                                                                <h4 class="product-detail-tag">
                                                                    <?php LanguageUtil::echoT('Address') ?>
                                                                    :
                                                                    <?php echo CityUtil::getCityName($product->address->city); ?></h4>
                                                                <?php echo $product->address->address; ?>
                                                            <?php endif; ?></div>
                                                    <?php endif; ?>
                                                    <div class="row-fluid">     
                                                        <div class="span12">
                                            <h4 class="product-detail-tag"> <?php LanguageUtil::echoT('Description') ?></h4>
                                                            <div class="slim-scroll" data-height="150">
                                                                <p><?php echo $product->description; ?></p>
                                                            </div>   
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="bando">                                                  
                                                    <?php if ($product->address->lat != null && $product->address->lon != null): ?>
                                                        <div class="row-fluid">                                                                                                                                                        
                                                            <h4 class="product-detail-tag"><?php LanguageUtil::echoT('City') ?>: <?php echo CityUtil::getCityName($product->address->city); ?></h4>                                        

                                                            <div id='map'></div>  
                                                            <script>
                                                                $('a[href="#bando"]').on('shown', function(e) {
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
                        <h3 class="title_font" style="text-transform:uppercase;"><?php LanguageUtil::echoT('Comments') ?></h3>
                        <hr/>
                        <div class="fb-comments" data-href="<?php echo $canonicalUrl; ?>" data-width="" data-num-posts="10"></div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12 custom">
                        <h3 class="title_font" style="text-transform:uppercase;" ><?php LanguageUtil::echoT('More like this') ?></h3>
                        <hr/>
                        <div id="userProductList" style="display:none;">
                            <?php foreach ($relateProductList as $relateProduct): ?>
                                <?php echo $relateProduct->renderHtml('home-user-'); ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
<script type="text/javascript" charset="utf-8" async defer>
    $(document).ready(function() {
        $('#userProductList').imagesLoaded(function() {
            masoryCenterAlign();
            $('#userProductList').show('fade');
            $('#userProductList').isotope('reLayout');
            setTimeout(function() {
                $('#userProductList').isotope('reLayout');
            }, 200);
        });
    });
</script>