<?php
/* @var $this SiteController */
/* @var $error array */
Yii::beginProfile('RenderSiteIndex');
$this->pageTitle = Yii::app()->name . ' - '. LanguageUtil::t("ITAKE.ME ! It's easy and so simple to internet marketing on your products, classified ads on Fashion, Mobile and Tablet, Desktop and Latop, Camera and Electrical Devices, Handmade and Art, Services, Real Estate, Car and Motobike, Others");
?>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/masonry.pkgd.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.infinitescroll.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile('http://maps.google.com/maps/api/js?sensor=true', CClientScript::POS_HEAD,false);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/gmaps.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/nada/site.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/nada/productDetails.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/nada/productControl.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/nada/map-util.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/nada/user-location.js', CClientScript::POS_END);
$cityList = json_encode(CityUtil::getCityList(true));
$jsCategory = $category !=null ? $category:'null';
$jsKeyword = $keyword!=null ? $keyword:'null';
Yii::app()->clientScript->registerScript('data',"
    var cityList = $cityList;
    var category = $jsCategory;
    var facebook = $facebook;
    var city = $city;
    var status= $status;
    var keyword = '$jsKeyword';
    ",  CClientScript::POS_HEAD);
$cityId = CityUtil::getSelectedCityId();
$canShowCityDialog = $cityId !=0 ? 'false':'true';
Yii::app()->clientScript->registerScript('showcity',"var canShowCityDialog = $canShowCityDialog;",CClientScript::POS_HEAD);

?>
<div class="container-fluid">
    <div class="row-fluid">

        <div class="sort-bar">
            <div class="selectedCategoryTab"> 
            <?php if (isset($categoryModel) && $categoryModel != null): ?>
                <?php $this->pageTitle = LanguageUtil::t($categoryModel->name) . " ".LanguageUtil::t('on')." ITAKE.ME" ?>
            
                <h1 class="title_font" style="font-size:1.5em;">
                    <?php echo $categoryModel->getIconAndNameHtml()."   ";?>
                    <?php if (strlen(CityUtil::getCityName($city))>0): ?>
                        <?php LanguageUtil::echoT($categoryModel->name);echo ' '; LanguageUtil::echoT('in');?>  <?php echo CityUtil::getCityName($city); ?>
                    <?php  else:?>     
                        <?php LanguageUtil::echoT($categoryModel->name);?>
                    <?php endif; ?>


                </h1>                                     
                <script>
                    $(function() {
                        var counter = 0;
                        var styleName = '<?php echo $categoryModel->styleName ?>';
                        $('.nav-text.all-cat-wrap').removeClass('selected');
                        $(".nav-text."+styleName.replace(' ','.')).addClass('selected');
                   
                    });
                </script>

            <?php endif; ?>
               </div>     
            <?php
                $currentSortType = SolrSortTypeUtil::getInstance()->getCurrentSortType();
                if($facebook==0&&(!isset($_GET['status'])||$_GET['status']!=3))
                    $sortTypeLink = SolrSortTypeUtil::getInstance()->makeSortTypeUrl($currentSortType);
                else
                    $sortTypeLink = "nothing";
            ?>
            <div class="pagination pagination-centered" style="z-index: 999;
position: relative;">
              <ul>
         
              <?php foreach (SolrSortTypeUtil::getInstance()->getSortTypeLinkList() as $link): ?>
                  <?php if(strpos($link, $sortTypeLink)!== FALSE):?>
                      <li class="active"><?php echo $link; ?></li>
                  <?php else: ?>
                      <li><?php echo $link; ?></li>
                  <?php endif; ?>
                  <?php break;?>
              <?php endforeach; ?>
                  
                <?php if($facebook==1&&isset($_GET['status'])&&$_GET['status']!=3):?>
                <li class="active">
                <?php else: ?>
                <li >
                <?php endif;?>
                    
                    <?php 
               
                        echo CHtml::link(
                                LanguageUtil::t('Facebook friend'),
                                $this->createUrl('/site/facebook')
                        );
                    
                    ?>
                </li>
              <?php if(isset($_GET['status'])&&$_GET['status']==3):?>
              <li class="active">
                  <?php else: ?>
              <li >
                  <?php endif;?>
                    <?php echo CHtml::link(LanguageUtil::t('Product sold'),
                        $this->createUrl('/site/sold'
                        )
                    );?>
                </li>
              </ul>
            </div>
        </div> 
        <div id="categories-bar">          
            <div class="row-fluid">     

                <ul>
                    <li><a href="<?php echo Yii::app()->createUrl('/site/index') ?>" title="<?php echo LanguageUtil::t('All')?>"><span class="nav-text all-cat-wrap selected mark"><small class="all-cat"></small><em></em>     &nbsp&nbsp<?php LanguageUtil::echoT('All') ?></span></a></li>                                                      
                    <?php foreach (CategoryUtil::getCategoryList() as $category): ?>
                        <li><a href="<?php echo $category->getUrl(); ?>" data-toggle="tooltip" title='<?php echo LanguageUtil::t($category->name)?>'><span class="nav-text <?php echo $category->getStyleName(); ?>"><small><i class="<?php echo $category->icon; ?> icon-large"></i> <em></em></small>      &nbsp&nbsp<?php LanguageUtil::echoT( $category->name);  ?></span></a></li>
                    <?php endforeach; ?>                    
                </ul>
            </div>       
        </div>        
        <div class="row-fluid" id="fixWidthMasory"></div>
        <div class="row-fluid">
        <div class="span2" id="menuWidthBase" style="height: 1000px;"><p>test</p></div>//do not remove
        <div class="span10">
            <div class="row-fluid" id="wrapper_productContainer" style="margin-top:120px;min-height:1000px;"   >
                <!-- <hr style="position:relative; top:-60px;"/> -->
                
                <?php if (trim($keyword) != ''): ?>
                    <div class="alert alert-info">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <b>Có <?php echo $numFound; ?> kết quả với từ khóa <?php echo $keyword; ?></b></div>                
                <?php endif; ?>
                <?php if($locationAddress !=null):?>
                    <div class="alert alert-info">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        Đang hiển thị các sản phẩm gần địa điểm <?php echo $locationAddress; ?>, <?php echo $locationCity; ?> | 
                        <?php echo CHtml::link('<i class="icon-remove"></i> Xóa vị trí',array('/site/removeLocation'));?>
                    </div>
                <?php endif; ?>
                <?php if($facebook && count($productList)==0):?>
                <div class="row-fluid">
                    <div class="span6 offset3">
                        <?php if(FacebookUtil::getInstance()->doUserHaveEnoughUploadPermission() ==false):?>
                            <p class="alert alert-info center">
                                <span class="icon-stack icon-2x">
                                  <i class="icon-circle icon-stack-base"></i>
                                  <i class="icon-facebook icon-light"></i>
                                </span>
                                <br>
                                Bạn cần kết nối tài khoản của bạn với Facebook để sử dụng chức năng này.
                            </p>
                            <div class="row-fluid center">
                            <?php echo FacebookUtil::getInstance()->makeFacebookLoginLink('Click để kết nối iTake với Facebook',  Yii::app()->createUrl("site/facebook")); ?>
                            </div>
                        <?php else:?>
                        <p class="alert alert-info center">
                             <span class="icon-stack icon-2x">
                                  <i class="icon-circle icon-stack-base"></i>
                                  <i class="icon-smile icon-light"></i>
                                </span>
                            <br>
                            Hiện tại chưa có sản phẩm nào được bán từ bạn bè của bạn, hãy mời họ sử dụng itake.
                        </p>
                        <?php endif; ?>
                        <hr class="margin-top-10"/>
                        <div class="fb-like center margin-top-10" data-href="<?php echo Yii::app()->getBaseUrl(true); ?>" data-width="auto" data-show-faces="true" data-send="true"></div>
                    </div>
                </div>
                <?php endif; ?>
                <?php
                Yii::beginProfile('RenderProductList'); 
                $this->renderPartial('/site/_board', array(
                    'productList' => $productList,
                    'nextPageLink' => $nextPageLink
                ));
                Yii::endProfile('RenderProductList');
                ?>
                <div id="loadingText"></div>
            </div>
            </div>
        </div>
    </div>
</div>


<?php echo $this->renderPartial('/site/_productDialog', array(), true, false); ?>
<?php $this->renderPartial('partial/cityDialog',array()); ?>
<?php Yii::endProfile('RenderSiteIndex'); ?>
