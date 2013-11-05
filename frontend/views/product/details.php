<?php
$this->pageTitle = $product->title;
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/nada/comment.js',  CClientScript::POS_END);
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