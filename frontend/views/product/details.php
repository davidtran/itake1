<?php
$this->
pageTitle = $product->title;
?>
<div class="row-fluid">
    <div class="productInfo">
        <div class='span12 custom customtop' id="mainProductInfo">

            <h1>
                <?php echo StringUtil::limitCharacter(strtoupper($product->title), 100); ?></h1>
            <div class="row-fluid">
                <div class="span6">
                    <div class="row-fluid">

                        <?php $this->
                        renderPartial('partial/images',array(
                            'product'=>$product
                        )); ?>
                    </div>
                    <div class="row-fluid" style="margin-top: 20px;">

                        <div class="fb-like" data-href="<?php echo $canonicalUrl; ?>
                            " data-send="false" data-layout="button_count" data-width="450" data-show-faces="false">
                        </div>
                        <br/>
                        <span class="" style="margin-bottom:10px;color:#005580;font-size:0.9em;"> <i class="icon-eye-open"></i>
                            <?php echo Yii::t('Default','{number} view|{number} views',array($product->view,'{number}'=>$product->view));   ?></span>
                        <!-- AddThis Button END --> </div>
                </div>
                <div class="span6 custom">
                    <div class="row-fluid">
                        <div class="bs-docs-example">
                            <ul id="myTab" class="nav nav-tabs">
                                <li class="active">
                                    <a href="#thongtinchung" data-toggle="tab"> <i class="icon-tags"></i>
                                        <?php LanguageUtil::echoT('General info') ?></a>
                                </li>
                                <li class="">
                                    <a id='btnShowMap' href="#bando" data-toggle="tab">
                                        <i class="icon-map-marker"></i>
                                        <?php LanguageUtil::echoT('Map') ?></a>
                                </li>
                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <div class="tab-pane fade active in" id="thongtinchung">
                                    <div class="row-fluid">
                                        <div class="span6">
                                            <h4 class="product-detail-tag">
                                                <?php LanguageUtil::echoT('Price') ?></h4>
                                            <span>
                                                <i class="icon-money"></i>
                                                <?php echo number_format($product->
                                                price); ?> VNĐ
                                                <br/>
                                            </span>
                                        </div>
                                        <div class="span6">
                                            <h4 class="product-detail-tag">
                                                <?php LanguageUtil::echoT('Seller') ?></h4>
                                            <i class="icon-user"></i>
                                            <?php echo $product->
                                            user->getUserProfileLink(); ?>
                                            <br/>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span6">
                                            <h4 class="product-detail-tag">
                                                <?php LanguageUtil::echoT('Phone') ?></h4>
                                            <i class="icon-phone-sign"></i>
                                            <?php echo $product->
                                            phone; ?>
                                            <br/>
                                        </div>
                                        <div class="span6">
                                            <h4 class="product-detail-tag">
                                                <?php LanguageUtil::echoT('Date') ?></h4>
                                            <i class="icon-calendar"></i>
                                            <?php echo DateUtil::convertDate('d-m-Y H:i:s', $product->create_date); ?></div>
                                    </div>
                                    <?php if ($product->
                                    lat != null && $product->lon != null): ?>
                                    <div class="row-fluid">

                                        <?php if (trim($product->
                                        locationText) != ''): ?>
                                        <h4 class="product-detail-tag">
                                            <?php LanguageUtil::echoT('Address') ?>
                                            :
                                            <?php echo CityUtil::getCityName($product->city); ?></h4>
                                        <?php echo $product->
                                        locationText; ?>
                                        <?php endif; ?></div>
                                    <?php endif; ?>
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <h4 class="product-detail-tag">
                                                <?php LanguageUtil::echoT('Description') ?></h4>
                                            <div class="slim-scroll" data-height="150">
                                                <p>
                                                    <?php echo $product->description; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <?php echo CHtml::link('Liên hệ','#',array(
                                                'class'=>
                                            'btn btn-primary',
                                                'id'=>'btnOpenMessageDialog'
                                            )); ?>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="bando">
                                    <?php if ($product->
                                    lat != null && $product->lon != null): ?>
                                    <div class="row-fluid">
                                        <h4 class="product-detail-tag">
                                            <?php LanguageUtil::echoT('City') ?>
                                            :
                                            <?php echo CityUtil::getCityName($product->city); ?></h4>

                                        <div id='map'></div>
                                        <script>
                                                $('a[href="#bando"]').on('shown', function(e) {
                                                    loadProductMap(currentProduct);
                                                })
                                            </script>
                                    </div>
                                    <?php endif; ?></div>
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
        <div class="row-fluid">
            <h3>
                <?php LanguageUtil::echoT('Comments') ?></h3>
        </div>
        <div class="row-fluid">
            <div class="fb-comments" data-href="<?php echo $canonicalUrl; ?>" data-width="" data-num-posts="10"></div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span12 custom">
        <div class="row-fluid">
            <h3>
                <?php LanguageUtil::echoT('More like this') ?></h3>
        </div>
        <div class="row-fluid">
            <div id="userProductList">
                <?php foreach ($relateProductList as $relateProduct): ?>
                <?php echo $relateProduct->
                renderHtml('home-user-'); ?>
                <?php endforeach; ?></div>
        </div>
    </div>
</div>