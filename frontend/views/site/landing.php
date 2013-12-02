<?php
/* @var $this SiteController */
/* @var $error array */

$this->
pageTitle = Yii::app()->name . ' - '. LanguageUtil::t("Easy to post to everywhere");
?>
<?php

?>
<div class="container-fluid">
	<div class="nav-bar-top nav-landing" >
		<div class="nd_logo ">
			<a class="logo" href="<?php echo $this->
				createUrl('/site'); ?>">
				<img src="/images/logo.png"/>
			</a>
			<small class="visible-desktop"></small>
		</div>

		<div class="frmSearch_wrapper">
			<ul class="social-bar">
				<li>
					<a href="https://www.facebook.com/itake.me">
                        Chúng tôi trên
						<span class="icon-stack"> <i class="icon-circle icon-stack-base"></i> <i class="icon-facebook icon-light"></i>
						</span>
					</a>
				</li>
			</ul>
			<?php if( Yii::app()->
			user->isGuest) :?>
			<div class="frmSearch pull-right">
<!--
				<a href="<?php echo Yii::app()->
					createUrl('user/register') ?>" class="btn btn-info" title="Browse the market">
					<i class="icon-user"></i>
					Đăng ký
				</a>
-->
				<a href="<?php echo Yii::app()->
					createUrl('user/login') ?>" class="btn btn-success" title="Browse the market">
					<i class="icon-signin"></i>
					Đăng nhập
				</a>
			</div>
			<?php endif; ?></div>

	</div>
	<div class="intro-top intro_item come-in">
		<div class="row-fluid" style="margin-top:20px;max-width: 1200px;">
			<div class="row-fluid">
                <div class="span6"></div>
                <div class="span6">
                    <div class="row-fluid">
                        <h1 class="title_font">Đăng tin rao vặt miễn phí, mua hàng thỏa thích <br>
                            <small class="center" style="text-align:center;">Với các sản phẩm cập nhật liên tục từ điện thoại thông minh, facebook và iTake web</small></h1>
                    </div>
                    <div class="row-fluid">
                        <a class="btn-xem-hang">Xem hàng</a>                        
                    </div>
                    <div class="row-fluid margin-top-10">
                        <a class="btn-fb-login">Đăng ký</a>
                    </div>
                </div>                
            </div>
	   </div>	  
    </div>
<div class="row-fluid intro_item">
	<div class="row-fluid" >
        <div class="row-fluid">
				<h3 class="title_font center">Tại sao tôi phải dùng iTake?</h3>
        </div>
		<div class="span10 offset1">
			<div class="row-fluid">
				<div class="span3">
					<img src="/images/01.png" class="intro-item-img"/>
				</div>
				<div class="span3">
					<img src="/images/02.png" class="intro-item-img"/>
				</div>
				<div class="span3">
					<img src="/images/03.png" class="intro-item-img"/>
				</div>
				<div class="span3">
					<img src="/images/04.png"class="intro-item-img"/>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row-fluid intro_item margin-top-20">
	<div class="row-fluid">
		<div class="span10 offset1">
			<div class="row-fluid">
				<h3 class="title_font center">Các sản phẩm đã được đăng lên iTake</h3>
			</div>
            <div class="row-fluid">
                <div class="span10 offset1">               	
                    <?php $this->renderPartial('_landing_products',array('listProducts'=>$listProducts)); ?>      
                </div>
            </div>
		</div>
	</div>
</div>
<div class="row-fluid intro_item">
	<h2 class="center title_font">Rao vặt Việt Nam đã thay đổi, khám phá ngay bây giờ</h2>
	<div class="span6 offset3">
		<h4 class="center"></h4>
	</div>
</div>
<div class="row-fluid intro-sep last intro_item">
	<div class="span6 offset4">
		<?php echo CHtml::link('Sign Up',array('/user/register'),array(
                'class'=>
		'btn btn-large wide'
            )); ?>
        <?php echo CHtml::link('Start exploring',array('site/index'),array(
                'class'=>
		'btn btn-success btn-primary  btn-large wide'
            )); ?>
	</div>
</div>
</div>