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
                    'error' => array('block' => true, 'fade' => true, 'closeText' => '×'), // success, info, warning, error or danger
                ),
            ));
            ?>
            <h1> <?php echo strtoupper($product->title); ?></h1>
            <div class="row-fluid">                            
                <div class="span6">
                    <div class="row-fluid">

                        <?php $this->renderPartial('partial/images',array(
                            'product'=>$product
                        )); ?>



                    </div>
                </div>
                <div class="span6 custom">
                    <div class="row-fluid">
                        <div class="bs-docs-example">
                            <ul id="myTab" class="nav nav-tabs">
                                <li class="active"><a href="#thongtinchung" data-toggle="tab"><i class="icon-tags icon-large"></i> <?php LanguageUtil::echoT('General info') ?></a></li>
                                <li class=""><a id='btnShowMap' href="#bando" data-toggle="tab"><i class="icon-map-marker icon-large"></i>  <?php LanguageUtil::echoT('Map') ?></a></li>                              
                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <div class="tab-pane fade active in" id="thongtinchung">
                                    <div class="row-fluid">
                                        <div class="span6">
                                            <h4 class="product-detail-tag">
                                            <?php LanguageUtil::echoT('Seller') ?></h4>
                                            <?php
                                            echo UserImageUtil::renderImage($product->user,array(
                                                'width' => 30,
                                                'height' => 30,
                                                'style' => 'width: 30px;
                                                height: 30px;',
                                                'class' => 'img-circle',
                                            ));
                                            ?>
                                            <?php echo $product->
                                                user->getUserProfileLink(); ?>
                                            <br/>

                                        </div>
                                        <div class="span6">
                                            <h4 class="product-detail-tag">
                                                <?php LanguageUtil::echoT('Price') ?></h4>
                                            <span>
                                                <i class="icon-money"></i>
                                                <?php if($product->no_price):?>
                                                    <?php echo Yii::t('Default','Contact price');?>
                                                <?php else:?>
                                                    <?php echo number_format($product->price);?> VNĐ
                                                <?php endif; ?>
                                                <br/>
                                            </span>
                                        </div>

                                    </div>
                                    <div class="row-fluid">

                                        <div class="span6">
                                            <h4 class="product-detail-tag">
                                                <?php LanguageUtil::echoT('Phone') ?></h4>
                                            <i class="icon-phone-sign"></i>
                                            <?php echo $product->phone; ?>
                                            <br/>
                                        </div>
                                        <div class="span6">
                                            <h4 class="product-detail-tag">
                                                <?php LanguageUtil::echoT('Date') ?></h4>
                                            <i class="icon-calendar"></i>
                                            <?php echo $product->displayDateTime(); ?>  
                                        </div>

                                    </div> 
                                    <?php if ($product->address!=null&&$product->address->lat != null && $product->address->lon != null): ?>
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
                                                <p><?php echo nl2br($product->description); ?></p>
                                            </div>   
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="bando">                                                  
                                    <?php if ($product->address!=null&&$product->address->lat != null && $product->address->lon != null): ?>
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
            <div class="row-fluid">
                <div class="span6">
                    <div class="row-fluid" style="margin-top: 30px;">
                        <div class="pull-left" style="margin-right: 10px;">

                            <div class="fb-like" data-href="<?php echo $canonicalUrl; ?>
                " data-send="false" data-layout="button_count" data-width="450" data-show-faces="false">
                            </div>
                            <!-- AddThis Button END -->
                        </div>
                        <div class="pull-left">
            <span class="" style="margin-bottom:10px;color:#005580;font-size:0.9em;"> <i class="icon-eye-open"></i>
                <?php echo Yii::t('Default','{number} view|{number} views',array($product->view,'{number}'=>$product->view));   ?></span>
                        </div>
                    </div>
                </div>

                <div class="span6">
                    <br>                                   
                    <?php echo CHtml::link('
                            <span class="icon-stack">
                              <i class="icon-circle icon-stack-base"></i>
                              <i class="icon-comments" style="color:#2f96b4"></i>
                            </span>'.'  Gửi tin nhắn','#',array(
                        'class'=>'btnOpenProductMessageDialog btn btn-info pull-right',
                        'style'=>'margin-right:10px;',
                        'data-product-id'=>$product->id
                    )); ?>
                </div>
            </div>

        </div>

    </div>

    </div>  
    <div class="row-fluid">
    
    <div class="span12 custom">
        <h3 class="title_font" style="text-transform:uppercase;"><?php LanguageUtil::echoT('Comments') ?></h3>
        <div class="fb-comments" data-href="<?php echo $canonicalUrl; ?>" data-width="" data-num-posts="10"></div>
    </div>
    </div>
    <?php if(count($relateProductList)>0): ?>
    <div class="row-fluid">
        <div class="span12 custom">
            <div class="row-fluid">
                <h3 class="title_font" style="text-transform:uppercase;">
                    <?php LanguageUtil::echoT('More like this') ?></h3>
            </div>
            <div class="row-fluid" style="margin-left:1%;">
                <div id="userProductList">
                    <?php foreach ($relateProductList as $relateProduct): ?>
                        <?php echo $relateProduct->
                            renderHtml('home-user-'); ?>
                    <?php endforeach; ?></div>
            </div>
        </div>
    </div>
    <?php endif; ?>