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
	        <a class="logo" href="<?php echo $this->createUrl('/welcome'); ?>"><h1><span>i</span>Take</h1></a>
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
<!--				<h1 class="center title_font font-white font-2x" style="text-shadow: 0px 1px 1px #000;-->
<!--        filter: dropshadow(color=#000, offx=1, offy=1);">ONCE POST TO MANY PLACES</h1>-->
                <div class="row-fluid" style="margin-top: 30px;">
                    <div class="span8 offset3">
                        <!-- Place somewhere in the <body> of your page -->
                        <div class="flexslider">
                            <ul class="slides">
                                <li>
                                    <img src="<?php echo Yii::app()->baseUrl.'/images/small_slide_1.png' ?>" />
                                </li>
                                <li>
                                    <img src="<?php echo Yii::app()->baseUrl.'/images/small_slide_2.png' ?>" />
                                </li>
                                <li>
                                    <img src="<?php echo Yii::app()->baseUrl.'/images/small_slide_3.png' ?>" />
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Place in the <head>, after the three links -->
                    <script type="text/javascript" charset="utf-8">
                        $(window).load(function() {
                            $('.flexslider').flexslider({
                                controlNav: false,
                                directionNav: false,
                                slideshowSpeed: 4000,
                                animationSpeed: 600
                            });
                        });
                    </script>
                </div>
                <div class="row-fluid offset2">
                    <?php echo CHtml::link('Start exploring',array('site/index'),array(
                        'class'=>'btn btn-large btn-primary wide emphasis'
                    )); ?>
                    <?php echo CHtml::link(Yii::t('Default','Sign up'),array('/user/register'),array(
                        'class'=>'btn btn-success btn-large wide emphasis'
                    )); ?>
                </div>
			</div>
			<div class="span6">
				<h1 class="center title_font font-white font-large">Great place to sell or buy anything...</h1>
			</div>
		</div>
		<div class="intro-image">
		</div>
	</div>
	<div class="row-fluid intro-sep intro_item" style="margin-top:560px;">
		<h1 class="center title_font"><i class="icon-quote-left"></i>  The market is beautiful, simple and efficient  <i class="icon-quote-right"></i></h1>
		<div class="row center">
			<small>ITAKE makes the market more beautiful, easy to use and really efficient when the buyer go social marketing</small>
		</div>			
		<div class="row center" style="margin-top:20px;">
			<img src="<?php echo Yii::app()->baseUrl.'/images/bmarket.png' ?>"/>
		</div>
	</div>
	<div class="row-fluid intro-sep intro_item">
	<div class="row-fluid" >
		<h1 class="center title_font">Simple to sell</h1>
		<div class="span3 offset1">
			<h2 class="center">
				<span class="icon-stack icon-2x green">
				  <i class="icon-circle icon-stack-base"></i>
				  <i class="icon-random icon-light"></i>
				</span>
			</h2>
			<h4 class="center intro_font">PROMOTED TO MILLION CUSTOMERS</h4>
			<div class="row center">
				<small>We support all plaforms from mobile to tablet and desktop for increasing the product engagement on internet</small>
			</div>
		</div>
		<div class="span3">
			<h2 class="center" >
				<span class="icon-stack icon-2x green">
				  <i class="icon-circle icon-stack-base"></i>
				  <i class="icon-tags icon-light"></i>
				</span>
			</h2>
			<h4 class="center intro_font">SELLING IN 3 CLICKS</h4>
			<div class="row center">
				<small>You post once with simple clicks to broadcast your product to facebook, ITAKE mobile app and ITAKE market</small>
			</div>
		</div>
		<div class="span3">
			<h2 class="center">
				<span class="icon-stack icon-2x green">
				  <i class="icon-circle icon-stack-base"></i>
				  <i class="icon-signal icon-light"></i>
				</span>
			</h2>
			<h4 class="center intro_font">SALE ANALYTIS</h4>
			<div class="row center">
				<small>ITAKE will statictis your products on sale with analytis system. We offer 3 analytic types: Weekly Sale Report, Realtime Report, Custom Report</small>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<h1 class="center title_font">Easy to buy</h1>
		<div class="span3 offset1">
			<h2 class="center">
				<span class="icon-stack icon-2x green">
				  <i class="icon-circle icon-stack-base"></i>
				  <i class="icon-screenshot icon-light"></i>
				</span>
			</h2>
			<h4 class="center intro_font">EASY TO FIND ANYTHING YOU WANT</h4>
			<div class="row center">
				<small>With best seach engine, You can find anything easier and moreover you can search base trend, time and location</small>
			</div>
		</div>
		<div class="span3">
			<h2 class="center" >
				<span class="icon-stack icon-2x green">
				  <i class="icon-circle icon-stack-base"></i>
				  <i class="icon-star icon-light"></i>
				</span>
			</h2>
			<h4 class="center intro_font">BUY PRODUCTS FROM YOUR FRIENDS</h4>
			<div class="row center">
				<small>ITAKE as a social buy & sell network, you will take a change to discover products from friends or friends of friends or get advice from your friends before to buy</small>
			</div>
		</div>
		<div class="span3">
			<h2 class="center">
				<span class="icon-stack icon-2x green">
				  <i class="icon-circle icon-stack-base"></i>
				  <i class="icon-filter icon-light"></i>
				</span>
			</h2>
			<h4 class="center intro_font">FROM ONLY TRUSTED SELLERS</h4>
			<div class="row center">
				<small>We ensure that we will choose trusted sellers and always buid trust to develop this network</small>
			</div>
		</div>
	</div>	
	</div>
	<div class="row-fluid intro_item">
		<h2 class="center title_font">Let's start exploring</h2>
		<div class="span6 offset3">
			<h4 class="center"></h4>
		</div>		
	</div>
	<div class="row-fluid intro-sep last intro_item">
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
