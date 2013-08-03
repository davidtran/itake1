<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - Điều khoản sử dụng Itake';
$this->breadcrumbs=array(
	'Giới thiệu',
);
?>
<div class="container-fluid " style="margin-top:44px;">	
	<div class="row-fluid intro-sep">
		<div class="span6 center">
			<img src="<?php echo Yii::app()->baseUrl.'/images/intro_1.png'; ?>">
		</div>
		<div class="span6" style="margin-top:54px;">
			<h2 class="center">ITAKE.ME ! Thật dễ dàng khi tiếp thị sản phẩm</h2>
			<div class="row center" style="margin-top:10px;">
				<a class="btn btn-success btn-large wide" href="<?php echo Yii::app()->createUrl('user/register') ?>">Đăng ký</a>
			</div>		
			<div class="row center" style="margin-top:10px;">
				hoặc <a href="<?php echo Yii::app()->createUrl('user/login') ?>">Đăng nhập</a>
			</div>					
		</div>
	</div>
	<div class="row-fluid intro-sep">
		<div class="span6 center" style="margin-top:104px;">
			<h2>Nhanh chóng và vô cùng tiện lợi</h2>
			<small>Bạn sẽ không còn băn khoăn khi tiếp thị sản phẩm ở nhiều website, hoặc mạng xã hội khác nhau. ITAKE sẽ giúp bạn, chỉ một thao tác nhỏ để sản phẩm bạn đến mọi nơi</small>			
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
			<h2>Chia sẻ sản phẩm đến bạn bè</h2>
			<small>Dễ dàng chia sẻ những sản phẩm của bạn tới bạn bè xung quanh</small>	
		</div>
	</div>
	<div class="row-fluid intro-sep">
		<div class="span6 center" style="margin-top:74px;">
			<h2>Tìm kiếm sản phẩm dễ dàng</h2>
			<small>Việc tìm kiếm sản phẩm sẽ phẩm được ITAKE làm cho đơn giản hơn bao giờ hết với bộ tìm kiếm tốt nhất</small>			
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
			<h2>An toàn và bảo mật</h2>
			<small>Chúng tôi bảo đảm mọi dữ liệu trên ITAKE luôn được an toàn với cơ chế bảo mật mới nhất</small>	
		</div>
	</div>
	<div class="row-fluid intro-sep last">
		<div class="span6 center" style="margin-top:44px;">	
			<h2>Không ngừng cải tiến</h2>
			<small>Với đội ngũ đầy đam mê, chúng tôi luôn tạo ra những ý tưởng đột phá để mang đến một sản phẩm hoàn hảo hơn, tiện lợi hơn và một sự trải nghiệm tuyệt vời hơn </small>					
		</div>
		<div class="span6 center">
			<img src="<?php echo Yii::app()->baseUrl.'/images/intro_6.png'; ?>">		
		</div>
	</div>
	<div class="row-fluid intro-sep last">
		<div class="span6 offset4">	
			<a class="btn btn-success btn-large wide" href="<?php echo Yii::app()->createUrl('user/register') ?>">Đăng ký</a>			
			<a class="btn btn-large wide" href="<?php echo Yii::app()->createUrl('site/index') ?>">Trang chủ</a>
		</div>		
	</div>
</div>