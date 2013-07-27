<?php 
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/masonry.pkgd.min.js',CClientScript::POS_HEAD);

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.infinitescroll.min.js',CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile('http://maps.google.com/maps/api/js?sensor=true',CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/gmaps.js',CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/nada/site.js',CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/nada/productDetails.js',CClientScript::POS_END);
?>
<div id="categories-bar">
    <ul>
        <li><a href="<?php echo Yii::app()->createUrl('site/index')?>"><span class="badge "><i class="icon-th"></i>   Tất cả</span></a></li>                                                      
        <?php foreach (CategoryUtil::getCategoryList() as $category): ?>
            <li><a href="<?php echo  $category->getUrl(); ?>" title='Xem tin rao vặt <?php echo $category->name; ?>'><span class="badge <?php echo $category->getStyleName(); ?>"> <i class="<?php echo  $category->icon; ?>"></i>   <?php echo $category->name; ?></span></a></li>
            <?php endforeach; ?>                    
    </ul>
     <?php if($categoryModel!=null):?>
<!--         <div class="selectedCategoryTab"> <h1>Danh mục: <?php echo $categoryModel->name; ?></h1></div>-->
    <script>
        $(function() {
            var counter = 0;     
            var styleName = '<?php echo $categoryModel->styleName?>';
            $('#categories-bar ul li a span').each(function() {                                
                var strClass="category_color id_"+counter;     
                if(styleName!=strClass){
                $(this).removeClass(strClass);                
                }
                counter++;
            });
        });
    </script>
    <?php endif; ?>
    <?php if(trim($keyword)!=''):?>
         <div style="float: left; width: 100%;margin-top: -10px;"><b>Có <?php echo $numFound; ?> kết quả với từ khóa <?php echo $keyword; ?></b></div>
    <?php endif; ?>
</div>  
<div class="row-fluid">       
    <?php $this->renderPartial('/site/_board',array(
        'productList'=>$productList,
        'nextPageLink'=>$nextPageLink
    )); ?>
    <div id="loadingText"></div>
</div>

<?php echo $this->renderPartial('/site/_productDialog',array(),true,false); ?>

