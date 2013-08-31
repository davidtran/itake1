<?php
/* @var $this SiteController */
/* @var $error array */
Yii::beginProfile('RenderSiteIndex');
$this->pageTitle = Yii::app()->name . ' - '. LanguageUtil::t("ITAKE.ME ! It's easy and so simple to internet marketing on your products, classified ads on Fashion, Mobile and Tablet, Desktop and Latop, Camera and Electrical Devices, Handmade and Art, Services, Real Estate, Car and Motobike, Others");
?>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/masonry.pkgd.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.infinitescroll.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile('http://maps.google.com/maps/api/js?sensor=true', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/gmaps.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/nada/site.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/nada/productDetails.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/nada/productControl.js', CClientScript::POS_END);
?>
<div class="container-fluid" style="margin-left:50px;">
    <div class="row-fluid">

        <div class="sort-bar">
                    <div class="pagination pagination-centered" >
                      <ul>
                         <?php foreach (SolrSortTypeUtil::getInstance()->getSortTypeLinkList() as $link): ?>
                            <li><?php echo $link; ?></li>
                        <?php endforeach; ?>
                        <li><a href="#">Ở gần bạn</a></li>
                        <li><a href="#">Bạn bè Facebook</a></li>
                      </ul>
                    </div>
        </div> 
        <div id="categories-bar">          
            <div class="row-fluid">     

                <ul>
                    <li><a href="<?php echo Yii::app()->createUrl('site/index') ?>" title="<?php echo LanguageUtil::t('All')?>"><span class="nav-text all-cat-wrap selected mark"><small class="all-cat"></small><em></em>     &nbsp&nbsp<?php LanguageUtil::echoT('All') ?></span></a></li>                                                      
                    <?php foreach (CategoryUtil::getCategoryList() as $category): ?>
                        <li><a href="<?php echo $category->getUrl(); ?>" title='<?php echo LanguageUtil::t($category->name)?>'><span class="nav-text <?php echo $category->getStyleName(); ?>"><small><i class="<?php echo $category->icon; ?> icon-large"></i> <em></em></small>      &nbsp&nbsp<?php LanguageUtil::echoT( $category->name);  ?></span></a></li>
                    <?php endforeach; ?>                    
                </ul>
            </div>    
            <div class="selectedCategoryTab"> 
            <?php if ($categoryModel != null): ?>
                <?php $this->pageTitle = $categoryModel->name . " ".LanguageUtil::t('on')." ITAKE.ME" ?>
            
                <h1>
                    <?php echo $categoryModel->getIconAndNameHtml()."   ";?>
                    <?php LanguageUtil::echoT($categoryModel->name); ?>
                </h1>                                     
                <script>
                    $(function() {
                        var counter = 0;
                        var styleName = '<?php echo $categoryModel->styleName ?>';
                        $('.nav-text.all-cat-wrap').removeClass('selected');
                        $(".nav-text."+styleName.replace(' ','.')).addClass('selected');
                        // $('#categories-bar ul li a span').each(function() {
                        //     var strClass = "category_color id_" + counter;
                        //     $(this).addClass("selected");
                        //     if (styleName != strClass) {
                        //         $(this).removeClass("selected");
                        //     }
                        //     counter++;
                        // });
                    });
                </script>
            <?php endif; ?>
               </div>        

        </div>        
        <div class="row-fluid" id="fixWidthMasory"></div>
        <div class="span9" style="margin-left:50px;">            
            <div class="row-fluid" id="wrapper_productContainer" style="margin-top:80px;"   >  
                <hr style="position:relative; top:-20px;"/>
                <?php if (trim($keyword) != ''): ?>
                    <div class="alert alert-info">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <b>Có <?php echo $numFound; ?> kết quả với từ khóa <?php echo $keyword; ?></b></div>
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

<?php echo $this->renderPartial('/site/_productDialog', array(), true, false); ?>

<?php Yii::endProfile('RenderSiteIndex'); ?>
