<?php
/* @var $this SiteController */
/* @var $error array */
Yii::beginProfile('RenderSiteIndex');
$this->pageTitle = Yii::app()->name . ' - '. LanguageUtil::t("ITAKE.ME ! It's easy and so simple to internet marketing on your products, classified ads on Fashion, Mobile and Tablet, Desktop and Latop, Camera and Electrical Devices, Handmade and Art, Services, Real Estate, Car and Motobike, Others");
?>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/masonry.pkgd.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.infinitescroll.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/nada/site.js', CClientScript::POS_HEAD);
?>
<div class="container-fluid">
    
    <div class="row-fluid">
<!--         <div class="span3">
            <?php echo $this->renderPartial('partial/categoryBar'); ?>   
        </div> -->
        
        
        <div class="span9" style="margin-left:149px;">            
            <div class="row-fluid" id="wrapper_categoryContainer" style="margin-top:100px;"   >  
                <div class="row-fluid" id="fixWidthMasory"></div>   
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
