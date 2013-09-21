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
        		<a href="<?php echo Yii::app()->createUrl('user/register') ?>" class="btn btn-top btn-info" title="Browse the market"><i class="icon-user"></i>  Đăng ký</a>
        		<a href="<?php echo Yii::app()->createUrl('user/login') ?>" class="btn btn-top btn-success" title="Browse the market"><i class="icon-signin"></i>  Đăng nhập</a>
        	</div>
        </div>  

	</div>
	<div class="intro-top">
		<div class="row-fluid" style="margin-top:20px;">
			<div class="span6">
				<h1 class="center title_font font-white font-2x" style="text-shadow: 0px 1px 1px #000;
        filter: dropshadow(color=#000, offx=1, offy=1);">BÁN HÀNG THÊM HIỆU QUẢ</h1>
			</div>
			<div class="span6">
				<h1 class="center title_font font-white font-large">Một nơi mà bạn dễ dàng bán hay mua bất kỳ thứ gì...</h1>
			</div>
		</div>
		<div class="intro-image">
		</div>
	</div>
	<div class="row-fluid intro-sep" style="margin-top:560px;">
		<h1 class="center title_font"><i class="icon-quote-left"></i>  ITAKE được thiết kế đẹp, đơn giản và hiệu quả kinh doanh cao <i class="icon-quote-right"></i></h1>
		<div class="row center">
			<small>Bạn không cần tạo website, không cần phải đăng tin nhiều nơi, với giao diện đẹp và những chức năng vượt trội. ITAKE sẽ giúp công việc bán hàng thêm đơn giản và hiệu quả</small>
		</div>			
		<div class="row center" style="margin-top:20px;">
			<img src="<?php echo Yii::app()->baseUrl.'/images/bmarket.png' ?>"/>
		</div>
	</div>
	<div class="row-fluid intro-sep">	
	<div class="row-fluid" >
		<h1 class="center title_font">Đơn giản để bán hàng</h1>
		<div class="span3 offset1">
			<h2 class="center">
				<span class="icon-stack icon-2x green">
				  <i class="icon-circle icon-stack-base"></i>
				  <i class="icon-random icon-light"></i>
				</span>
			</h2>
			<h4 class="center intro_font">QUẢNG CÁO TỚI HÀNG TRIỆU NGƯỜI DÙNG</h4>
			<div class="row center">
				<small>ITAKE có mặt trên tất cả mọi nền tảng từ ứng dụng di động đến máy tính bảng và máy tính </small>
			</div>
		</div>
		<div class="span3">
			<h2 class="center" >
				<span class="icon-stack icon-2x green">
				  <i class="icon-circle icon-stack-base"></i>
				  <i class="icon-tags icon-light"></i>
				</span>
			</h2>
			<h4 class="center intro_font">BÁN HÀNG CHỈ TRONG 3 CLICKS</h4>
			<div class="row center">
				<small>Với đơn giản 3 clicks bạn sẽ đưa sản phẩm của mình lên Facebook, Facebook fanpage, ứng dụng ITAKE trên điện thoại thông minh và trên website ITAKE</small>
			</div>
		</div>
		<div class="span3">
			<h2 class="center">
				<span class="icon-stack icon-2x green">
				  <i class="icon-circle icon-stack-base"></i>
				  <i class="icon-signal icon-light"></i>
				</span>
			</h2>
			<h4 class="center intro_font">PHÂN TÍCH HIỆU QUẢ TIẾP THỊ</h4>
			<div class="row center">
				<small>ITAKE sẽ thống kê sản phẩm của bạn khi bắt đầu tải lên thông qua lượt share, view và hiệu quả tổng thể của việc bán hàng trực tuyến với báo cáo đến bạn bán hàng hàng tuần</small>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<h1 class="center title_font">Dễ dàng để mua</h1>
		<div class="span3 offset1">
			<h2 class="center">
				<span class="icon-stack icon-2x green">
				  <i class="icon-circle icon-stack-base"></i>
				  <i class="icon-screenshot icon-light"></i>
				</span>
			</h2>
			<h4 class="center intro_font">DỄ DÀNG TÌM THỨ BẠN MUỐN</h4>
			<div class="row center">
				<small>Tìm kiếm dễ dàng với công cụ tìm kiếm tối ưu và tìm kiếm dựa trên xu hướng, thời gian và địa điểm</small>
			</div>
		</div>
		<div class="span3">
			<h2 class="center" >
				<span class="icon-stack icon-2x green">
				  <i class="icon-circle icon-stack-base"></i>
				  <i class="icon-star icon-light"></i>
				</span>
			</h2>
			<h4 class="center intro_font">MUA SẢN PHẨM TỪ BẠN BÈ</h4>
			<div class="row center">
				<small>ITAKE luôn xem trọng vào mối quan hệ từ Facebook vì vậy khi bạn của bạn bán một thứ gì đó thì bạn cũng dễ dàng tìm thấy trên Facebook, ứng dụng ITAKE hay Web ITAKE</small>
			</div>
		</div>
		<div class="span3">
			<h2 class="center">
				<span class="icon-stack icon-2x green">
				  <i class="icon-circle icon-stack-base"></i>
				  <i class="icon-filter icon-light"></i>
				</span>
			</h2>
			<h4 class="center intro_font">BÁN HÀNG TIN CẬY</h4>
			<div class="row center">
				<small>Chúng tôi luôn kiểm soát chất lượng của người bán hàng khi tham gia bán hàng trên ITAKE để đảm bảo sản phẩm rao bán trên ITAKE là đáng tin cậy</small>
			</div>
		</div>
	</div>	
	</div>
	<div class="row-fluid">
		<h2 class="center title_font">Hãy cùng khám phá không gian mua bán mới hoàn toàn</h2>
		<div class="span6 offset3">
			<h4 class="center"></h4>
		</div>		
	</div>
	<div class="row-fluid intro-sep last">
		<div class="span6 offset4">	
			<?php echo CHtml::link('Khám phá',array('site/index'),array(
                'class'=>'btn btn-large btn-primary wide'
            )); ?>
			<?php echo CHtml::link('Đăng ký ngay',array('/user/register'),array(
                'class'=>'btn btn-success btn-large wide'
            )); ?>
            
            
		</div>		
	</div>
</div>
