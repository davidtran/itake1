<?php
$this->pageTitle = $product->title;
?>
<div id="productDialogBody">
    <?php $this->renderPartial('dialogContent',array(
        'product'=>$product,
        'relateProductList'=>$relateProductList,
        'canonicalUrl'=>$canonicalUrl,
    )); ?>


</div>

<?php if(Yii::app()->language!='vi'): ?>
    <?php $this->renderPartial('partial/buyinginstruction',array('product'=>$product)); ?>
<?php else: ?>
    <?php $this->renderPartial('partial/buyinginstruction_vi',array('product'=>$product)); ?>
<?php endif; ?>