<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle = Yii::app()->name . ' - '. LanguageUtil::t("Easy to post to everywhere");
?>
<?php

?>
<div class="container-fluid">
	<div class="nav-bar-top" >
	    <div class="nd_logo">
	        <a class="logo" href="<?php echo $this->createUrl('/site'); ?>"><h1>ITAKE.ME</h1></a>
	        <small class="visible-desktop"></small>               
	    </div>
	    <div class="frmSearch_wrapper">                          
        	<div class="frmSearch pull-right">     
        		<a href="<?php echo Yii::app()->createUrl('user/register') ?>" class="btn btn-top btn-info" title="Browse the market"><i class="icon-user"></i>  Sign Up</a>
        		<a href="<?php echo Yii::app()->createUrl('user/login') ?>" class="btn btn-top btn-success" title="Browse the market"><i class="icon-signin"></i>  Sign In</a>
        	</div>
        </div>  

	</div>
	<div class="intro-top">
		<div class="row-fluid" style="margin-top:20px;">
			<div class="span6">
				<h1 class="center title_font font-white font-2x">ONCE POST TO MANY PLACES</h1>
			</div>
			<div class="span6">
				<h1 class="center title_font font-white font-large">Great place to sell or buy anything...</h1>
			</div>
		</div>
		<div class="intro-image">
		</div>
	</div>
	<div class="row-fluid" style="margin-top:550px;">
		<hr/>
		<h1 class="center title_font">FOR SELLER...</h1>
		<div class="span3 offset1">
			<h2 class="center">
				<span class="icon-stack icon-2x">
				  <i class="icon-circle icon-stack-base"></i>
				  <i class="icon-random icon-light"></i>
				</span>
			</h2>
			<h4 class="center">Your product is promoted to million customers on our website, mobile app and Facebook</h4>
		</div>
		<div class="span3">
			<h2 class="center" >
				<span class="icon-stack icon-2x">
				  <i class="icon-circle icon-stack-base"></i>
				  <i class="icon-tags icon-light"></i>
				</span>
			</h2>
			<h4 class="center">Start selling with ease in 3 clicks</h4>
		</div>
		<div class="span3">
			<h2 class="center">
				<span class="icon-stack icon-2x">
				  <i class="icon-circle icon-stack-base"></i>
				  <i class="icon-group icon-light"></i>
				</span>
			</h2>
			<h4 class="center">Easiest way to post your stuffs to your friends and friends of friends</h4>
		</div>
	</div>
	<div class="row-fluid">
		<hr/>
		<h1 class="center title_font">FOR BUYER...</h1>
		<div class="span3 offset1">
			<h2 class="center">
				<span class="icon-stack icon-2x">
				  <i class="icon-circle icon-stack-base"></i>
				  <i class="icon-screenshot icon-light"></i>
				</span>
			</h2>
			<h4 class="center">Easy to find out products which you like</h4>
		</div>
		<div class="span3">
			<h2 class="center" >
				<span class="icon-stack icon-2x">
				  <i class="icon-circle icon-stack-base"></i>
				  <i class="icon-star icon-light"></i>
				</span>
			</h2>
			<h4 class="center">You could buy good stuffs from your friends you know</h4>
		</div>
		<div class="span3">
			<h2 class="center">
				<span class="icon-stack icon-2x">
				  <i class="icon-circle icon-stack-base"></i>
				  <i class="icon-cogs icon-light"></i>
				</span>
			</h2>
			<h4 class="center">Only trusted sellers</h4>
		</div>
	</div>	
	<div class="row-fluid">
		<hr/>
		<h2 class="center">Let's start exploring</h2>
		<div class="span6 offset3">
			<h4 class="center"></h4>
		</div>		
	</div>
	<div class="row-fluid intro-sep last">
		<div class="span6 offset4">	
			<?php echo CHtml::link('Start exploring',array('site/index'),array(
                'class'=>'btn btn-large btn-primary wide'
            )); ?>
			<?php echo CHtml::link(Yii::t('Default','Sign up'),array('/user/register'),array(
                'class'=>'btn btn-success btn-large wide'
            )); ?>
            
            
		</div>		
	</div>
</div>
