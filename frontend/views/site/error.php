<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>
<div class="container-fluid" style="margin-top:44px;">
    <div class="span12">
        <h2 class="center title_font" style="color:#194675;">
            <i class="icon-frown icon-4x"></i>
            <br>
            Hix, Lỗi rồi. Lỗi <?php echo $code; ?></h2>
        <div class="error center">
            <?php echo CHtml::encode($message); ?>
        </div>
    </div>
</div>