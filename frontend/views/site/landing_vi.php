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
						<span class="icon-stack"> <i class="icon-circle icon-stack-base"></i> <i class="icon-facebook icon-light"></i>
						</span>
					</a>
				</li>
			</ul>
			<?php if( Yii::app()->
			user->isGuest) :?>
			<div class="frmSearch pull-right">
				<a href="<?php echo Yii::app()->
					createUrl('user/register') ?>" class="btn btn-info" title="Browse the market">
					<i class="icon-user"></i>
					Đăng ký
				</a>
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
			<div class="span6">
				<!--				<h1 class="center title_font font-white font-2x" style="text-shadow: 0px 1px 1px #000;-->
				<!--        filter: dropshadow(color=#000, offx=1, offy=1);">BÁN HÀNG THÊM HIỆU QUẢ</h1>
			-->
			<div class="row-fluid" style="margin-top: 30px;">
				<div class="span8 offset3">
					<!-- Place somewhere in the <body>
					of your page -->
					<div class="flexslider">
						<ul class="slides">
							<li>
								<img src="<?php echo Yii::app()->baseUrl.'/images/small_slide_1.png' ?>" /></li>
							<li>
								<img src="<?php echo Yii::app()->baseUrl.'/images/small_slide_2.png' ?>" /></li>
							<li>
								<img src="<?php echo Yii::app()->baseUrl.'/images/small_slide_3.png' ?>" /></li>
						</ul>
					</div>
				</div>
				<!-- Place in the <head>
				, after the three links -->
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
				<?php echo CHtml::link('Khám phá',array('site/index'),array(
                        'class'=>
				'btn btn-large btn-primary wide emphasis'
                    )); ?>
				<?php if( Yii::app()->
				user->isGuest) :?>
				<?php echo CHtml::link('Đăng ký ngay',array('/user/register'),array(
	                        'class'=>
				'btn btn-success btn-large wide emphasis'
	                    )); ?>
				<?php endif; ?></div>
		</div>
		<div class="span6">
			<h1 class="center title_font font-white font-large">Mua có thông tin - Bán được dễ dàng</h1>
		</div>
	</div>
	<div class="intro-image"></div>
</div>
<div class="row-fluid intro-sep intro_item" style="margin-top:560px;">
	<div class="row-fluid" >
		<div class="span10 offset1">
			<div class="row-fluid">
				<div class="span3">
					<h2 class="center">
						<span class="icon-stack icon-2x green">
							<i class="icon-circle icon-stack-base"></i>
							<i class="icon-thumbs-up icon-light"></i>
						</span>
					</h2>
					<h4 class="center intro_font">MUA HÀNG TỐT NHẤT</h4>
					<div class="row center">
						<small>
							Bạn muốn tham khảo bình chọn, đánh giá của người tiêu dùng trước khi mua hàng? Bạn không muốn mua phải những hàng xấu? iTake đã có chức năng bình chọn, nhận xét, hoặc báo xấu về một loại hàng hóa giúp bạn dễ dàng tìm những sản phẩm tốt nhất
						</small>
					</div>
				</div>
				<div class="span3">
					<h2 class="center" >
						<span class="icon-stack icon-2x green">
							<i class="icon-circle icon-stack-base"></i>
							<i class="icon-group  icon-light"></i>
						</span>
					</h2>
					<h4 class="center intro_font">MUA HÀNG TỪ NGƯỜI QUEN</h4>
					<div class="row center">
						<small>
							Bạn có thích xem bạn bè trên facebook của mình đang bán gì ? Mua hàng từ bạn bè sẽ đáng tin hơn? iTake sẽ giúp bạn dễ dàng thấy được những sản phẩm từ bạn bè trên facebook
						</small>
					</div>
				</div>
				<div class="span3">
					<h2 class="center">
						<span class="icon-stack icon-2x green">
							<i class="icon-circle icon-stack-base"></i>
							<i class="icon-coffee icon-light"></i>
						</span>
					</h2>
					<h4 class="center intro_font">MUA ĐƯỢC DỄ DÀNG</h4>
					<div class="row center">
						<small>
							Bạn muốn mua những sản phẩm mới nhất, gần mình nhất và đa dạng để lựa chọn. Chức năng tìm kiếm đơn giản của iTake giúp bạn dễ dàng kiếm những thứ mình cần
						</small>
					</div>
				</div>
				<div class="span3">
					<h2 class="center">
						<span class="icon-stack icon-2x green">
							<i class="icon-circle icon-stack-base"></i>
							<i class="icon-coffee icon-light"></i>
						</span>
					</h2>
					<h4 class="center intro_font">MUA ĐƯỢC DỄ DÀNG</h4>
					<div class="row center">
						<small>
							Bạn muốn mua những sản phẩm mới nhất, gần mình nhất và đa dạng để lựa chọn. Chức năng tìm kiếm đơn giản của iTake giúp bạn dễ dàng kiếm những thứ mình cần
						</small>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row-fluid intro_item">
	<div class="row-fluid">
		<div class="span10 offset1">
			<div class="row-fluid">
				<h3 class="title_font center">Các mặt hàng hiện có trên iTake</h3>
			</div>
		</div>
	</div>
</div>
<div class="row-fluid intro_item">
	<h2 class="center title_font">Hãy cùng khám phá không gian mua bán mới hoàn toàn</h2>
	<div class="span6 offset3">
		<h4 class="center"></h4>
	</div>
</div>
<div class="row-fluid intro-sep last intro_item">
	<div class="span6 offset4">
		<?php echo CHtml::link('Khám phá',array('site/index'),array(
                'class'=>
		'btn btn-large btn-primary wide'
            )); ?>
		<?php echo CHtml::link('Đăng ký ngay',array('/user/register'),array(
                'class'=>
		'btn btn-success btn-large wide'
            )); ?>
	</div>
</div>
</div>