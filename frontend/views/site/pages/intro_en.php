<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - Giới thiệu ITAKE';
$this->breadcrumbs=array(
	'Giới thiệu',
);
?>
<div class="container-fluid " style="margin-top:44px;">	
	<div class="row-fluid intro-sep">
		<div class="span6 center">
			<img src="<?php echo Yii::app()->baseUrl.'/images/intro_1.png'; ?>">
		</div>
		<div class="span6" style="margin-top:44px;">
			<h2 class="center">ITAKE.ME ! It's easy and so simple to internet marketing</h2>
			<div class="row center" style="margin-top:40px;">
				<a class="btn btn-success btn-large wide" href="<?php echo Yii::app()->createUrl('user/register') ?>">Sign Up</a>
			</div>		
			<div class="row center" style="margin-top:10px;">
				hoặc <a href="<?php echo Yii::app()->createUrl('user/login') ?>">Sign In</a>
			</div>					
		</div>
	</div>
	<div class="row-fluid intro-sep">
		<div class="span6 center" style="margin-top:104px;">
			<h2>Quick and extremely convenient</h2>
			<small>You will no longer wonder how to marketing your products on many websites or social networks, how to determine where to sell. ITAKE will help you, just a simple step to post your product to everywhere</small>			
		</div>
		<div class="span6 center">
			<img src="<?php echo Yii::app()->baseUrl.'/images/intro_2.png'; ?>">
		</div>
	</div>	
	<div class="row-fluid intro-sep">
		<div class="span6 center">
			<img src="<?php echo Yii::app()->baseUrl.'/images/intro_3.png'; ?>">		
		</div>
		<div class="span6 center" style="margin-top:84px;">
			<h2>Share and have fun</h2>
			<small>Easy to share your product to everywhere</small>	
		</div>
	</div>
	<div class="row-fluid intro-sep">
		<div class="span6 center" style="margin-top:74px;">
			<h2>Search everything quite easily</h2>
			<small>The search engine was made simpler than ever to find the best</small>			
		</div>
		<div class="span6 center">
			<img src="<?php echo Yii::app()->baseUrl.'/images/intro_4.png'; ?>">
		</div>
	</div>
		
	<div class="row-fluid intro-sep">
		<div class="span6 center">
			<img src="<?php echo Yii::app()->baseUrl.'/images/intro_5.png'; ?>">
		</div>
		<div class="span6 center" style="margin-top:44px;">			
			<h2>Safe and secure</h2>
			<small>We ensure that your data is always safe with the latest security technology</small>	
		</div>
	</div>
	<div class="row-fluid intro-sep last">
		<div class="span6 center" style="margin-top:44px;">	
			<h2>Constantly improvement</h2>
			<small>With a full of passion, our team, we always create inno-ideas to bring a perfect product, more convenient with a great experience</small>					
		</div>
		<div class="span6 center">
			<img src="<?php echo Yii::app()->baseUrl.'/images/intro_6.png'; ?>">		
		</div>
	</div>
	<div class="row-fluid intro-sep last">
		<div class="span6 offset4">	
			<a class="btn btn-success btn-large wide" href="<?php echo Yii::app()->createUrl('user/register') ?>">Sign Up</a>			
			<a class="btn btn-large wide" href="<?php echo Yii::app()->createUrl('site/index') ?>">Home</a>
		</div>		
	</div>
</div>