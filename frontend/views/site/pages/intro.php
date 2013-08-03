<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - Điều khoản sử dụng Itake';
$this->breadcrumbs=array(
	'Giới thiệu',
);
?>
<div class="container-fluid " style="margin-top:44px;">	
	<div class="row-fluid">
		<div class="span6">
			<img src="https://dt8kf6553cww8.cloudfront.net/static/images/index/nonretina/devices-vfl3TTUs-.png">
		</div>
		<div class="span6">
			<h2>ITAKE.ME ! Thật dễ dàng khi rao vặt</h2>
			<a class="btn btn-success btn-large" href="<?php echo Yii::app()->createUrl('user/register') ?>">Đăng ký</a>
			hoặc
			<a href="<?php echo Yii::app()->createUrl('user/login') ?>">Đăng nhập</a>
		</div>
	</div>
</div>