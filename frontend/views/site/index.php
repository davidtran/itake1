<?php 
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/masonry.pkgd.min.js',CClientScript::POS_HEAD);

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.infinitescroll.min.js',CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile('http://maps.google.com/maps/api/js?sensor=true',CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/gmaps.js',CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/nada/site.js',CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/nada/productDetails.js',CClientScript::POS_END);
?>
<div class="container-fluid">
  <div class="row-fluid">
      <div id="categories-bar">
        <div class="row-fluid">
            <div class="btn-group" style="float:right;margin-bottom:20px;margin-right:5px;">                                   
                    <Button class="btn flat dropdown-toggle" data-toggle="dropdown"style="border-radius:0px;width:50px;"> 
                       <i class="icon-sort-by-attributes"></i>                                         
                       <span class="caret"></span>
                   </Button>
                   <ul class="dropdown-menu" style="border-radius:0px;position:fixed;top:95px;">                                    
                        <?php foreach(SolrSortTypeUtil::getInstance()->getSortTypeLinkList() as $link):?>
                        <li><?php echo $link; ?></li>
                        <?php endforeach; ?>
                    </ul>
            </div>
        </div>    
         <div class="row-fluid">     
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('site/index')?>" title="Xem tất cả"><span class="nav-text all-cat-wrap selected mark"><small class="all-cat"></small><em></em></span></a></li>                                                      
                <?php foreach (CategoryUtil::getCategoryList() as $category): ?>
                <li><a href="<?php echo  $category->getUrl(); ?>" title='Xem tin rao vặt <?php echo $category->name; ?>'><span class="nav-text <?php echo $category->getStyleName(); ?>"><small><i class="<?php echo  $category->icon; ?> icon-large"></i> <em></em></small>  <?php //echo $category->name; ?></span></a></li>
            <?php endforeach; ?>                    
            </ul>
        </div>    
    <?php if($categoryModel!=null):?>
    <!--         <div class="selectedCategoryTab"> <h1>Danh mục: <?php echo $categoryModel->name; ?></h1></div>-->
    <script>
    $(function() {
      var counter = 0;     
      var styleName = '<?php echo $categoryModel->styleName?>';
      $('#categories-bar ul li a span').each(function() {      
        var strClass="category_color id_"+counter;                                       
        $(this).addClass("selected");            
        $(this).addClass("mark"); 
        if(styleName!=strClass){
                //$(this).removeClass(strClass);  
                $(this).removeClass("selected");              
                $(this).removeClass("mark");
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
  <div class="row-fluid" style="margin-top:80px;">       
    <?php $this->renderPartial('/site/_board',array(
        'productList'=>$productList,
        'nextPageLink'=>$nextPageLink
        )); ?>
        <div id="loadingText"></div>
    </div>
</div>
</div>

<?php echo $this->renderPartial('/site/_productDialog',array(),true,false); ?>

