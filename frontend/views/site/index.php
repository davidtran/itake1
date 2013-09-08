<?php
/* @var $this SiteController */
/* @var $error array */
Yii::beginProfile('RenderSiteIndex');
$this->pageTitle = Yii::app()->name . ' - '. LanguageUtil::t("ITAKE.ME ! It's easy and so simple to internet marketing on your products, classified ads on Fashion, Mobile and Tablet, Desktop and Latop, Camera and Electrical Devices, Handmade and Art, Services, Real Estate, Car and Motobike, Others");
?>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/masonry.pkgd.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.infinitescroll.min.js', CClientScript::POS_HEAD);



?>
<div class="container-fluid" style="margin-left:50px;">
    <div class="row-fluid">
 
        <div id="categories-bar">          
            <div class="row-fluid">     

                <ul>
                    <li><a href="<?php echo Yii::app()->createUrl('/site/index') ?>" title="<?php echo LanguageUtil::t('All')?>"><span class="nav-text all-cat-wrap selected mark"><small class="all-cat"></small><em></em>     &nbsp&nbsp<?php LanguageUtil::echoT('All') ?></span></a></li>                                                      
                    <?php foreach (CategoryUtil::getCategoryList() as $category): ?>
                        <li><a href="<?php echo $category->getUrl(); ?>" title='<?php echo LanguageUtil::t($category->name)?>'><span class="nav-text <?php echo $category->getStyleName(); ?>"><small><i class="<?php echo $category->icon; ?> icon-large"></i> <em></em></small>      &nbsp&nbsp<?php LanguageUtil::echoT( $category->name);  ?></span></a></li>
                    <?php endforeach; ?>                    
                </ul>
            </div>    
            

        </div>        
        <div class="row-fluid" id="fixWidthMasory"></div>
        <div class="span9" style="margin-left:50px;">            
            <div class="row-fluid" id="wrapper_categoryContainer" style="margin-top:80px;"   >  
                <div class="categoryList">
                    <ul class="thumbnails">
                        <?php foreach($categoryList as $category):?>
                            <?php $this->renderPartial('partial/categoryItem', array(
                                'category'=>$category
                            )); ?>
                        <?php endforeach;?>
                    </ul>
                    
                </div>
            </div>
         </div>
    </div>
</div>

<?php Yii::endProfile('RenderSiteIndex'); ?>
