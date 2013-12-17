<?php
$this->pageTitle = $product->title;
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.elevateZoom-2.5.5.min.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/chat/app.js', CClientScript::POS_HEAD);
?>

<div class="row-fluid">
    
    <div class="close_tag" style="top:45px;"> 
        <a style="padding:20px;" class="close"  href="<?php echo $this->createUrl('/site/index'); ?>"><i class="icon-home"></i></a>
    </div>

    <div id="detailProduct"style="display: block; margin-top: 0px;">                    
        <div id="detailProductBody" style="">
            <div id="productDialogBody">
                <?php $this->renderPartial('dialogContent',array(
                    'product'=>$product,
                    'relateProductList'=>$relateProductList,
                    'canonicalUrl'=>$canonicalUrl,
                )); ?>


            </div>
        </div>
    </div>
</div>
<script type="text/javascript" charset="utf-8" async defer>
    $(document).ready(function() {
        $('#userProductList').imagesLoaded(function() {
            masoryCenterAlign();
            alignDiv();
            $('#userProductList').show('fade');
            $('#userProductList').isotope('reLayout');
            setTimeout(function() {
                $('#userProductList').isotope('reLayout');
            }, 200);
        });
    });
</script>
<?php if(Yii::app()->language!='vi'): ?>
    <?php $this->renderPartial('partial/buyinginstruction',array('product'=>$product)); ?>
<?php else: ?>
    <?php $this->renderPartial('partial/buyinginstruction_vi',array('product'=>$product)); ?>
<?php endif; ?>

<div id="messageDialogContainer">
    
</div>