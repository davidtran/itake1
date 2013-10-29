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
	        <a class="logo" href="<?php echo $this->createUrl('/site'); ?>"><h1><span>i</span>Take</h1></a>
	        <small class="visible-desktop"></small>               
	    </div>
	    <?php if( Yii::app()->user->isGuest) :?>
	    <div class="frmSearch_wrapper">                          
        	<div class="frmSearch pull-right">     
        		<a href="<?php echo Yii::app()->createUrl('user/register') ?>" class="btn btn-top btn-info" title="Browse the market"><i class="icon-user"></i>  Đăng ký</a>
        		<a href="<?php echo Yii::app()->createUrl('user/login') ?>" class="btn btn-top btn-success" title="Browse the market"><i class="icon-signin"></i>  Đăng nhập</a>
        	</div>
        </div>  
		 <?php endif; ?>
	</div>
	<div class="intro-top intro_item come-in">
		<div class="row-fluid" style="margin-top:20px;max-width: 1200px;">
			<div class="span6">
<!--				<h1 class="center title_font font-white font-2x" style="text-shadow: 0px 1px 1px #000;-->
<!--        filter: dropshadow(color=#000, offx=1, offy=1);">BÁN HÀNG THÊM HIỆU QUẢ</h1>-->
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
                    <?php echo CHtml::link('Khám phá',array('site/index'),array(
                        'class'=>'btn btn-large btn-primary wide emphasis'
                    )); ?>
                    <?php if( Yii::app()->user->isGuest) :?>
	                    <?php echo CHtml::link('Đăng ký ngay',array('/user/register'),array(
	                        'class'=>'btn btn-success btn-large wide emphasis'
	                    )); ?>
                	<?php endif; ?>
                </div>
			</div>
			<div class="span6">
				<h1 class="center title_font font-white font-large">Mua có thông tin - Bán được dễ dàng</h1>
			</div>
		</div>
		<div class="intro-image">
		</div>
	</div>
	<div class="row-fluid intro-sep intro_item" style="margin-top:560px;">
		<h1 class="center title_font"><i class="icon-quote-left"></i>iTake - Trung tâm thương mại online đầu tiên của người Việt <i class="icon-quote-right"></i></h1>
		<div class="span9 offset1 center">
			<small class="center">Bạn không cần tốn tiền thuê mặt bằng để bán hàng, Bạn không cần tạo một website, Bạn không cần làm tối ưu hóa website hay hàng ngày cập nhật sản phẩm lên facebook. Dù bạn lớn hay nhỏ, Chỉ cần sản phẩm của bạn tốt Khách hàng sẽ tìm đến bạn. Thời đại của mua sắm Online Việt đã phát triển và uy tín hơn. Bạn sẽ dễ dàng và nhanh chóng tìm được những hàng hóa mình cần trên iTake </small>
		</div>			
		<div class="row center">
			<img  style="padding-top:40px;"src="<?php echo Yii::app()->baseUrl.'/images/bmarket.png' ?>"/>
		</div>
	</div>
	<div class="row-fluid intro-sep intro_item">
	<div class="row-fluid" >
		<h1 class="center title_font">Mua có thông tin</h1>
		<div class="span3 offset1">
			<h2 class="center">
				<span class="icon-stack icon-2x green">
				  <i class="icon-circle icon-stack-base"></i>
				  <i class="icon-thumbs-up icon-light"></i>
				</span>
			</h2>
			<h4 class="center intro_font">MUA HÀNG TỐT NHẤT</h4>
			<div class="row center">
				<small>Bạn muốn tham khảo bình chọn, đánh giá của người tiêu dùng trước khi mua hàng? Bạn không muốn mua phải những hàng xấu? iTake đã có chức năng bình chọn, nhận xét, hoặc báo xấu về một loại hàng hóa giúp bạn dễ dàng tìm những sản phẩm tốt nhất </small>
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
				<small>Bạn có thích xem bạn bè trên facebook của mình đang bán gì ? Mua hàng từ bạn bè sẽ đáng tin hơn? iTake sẽ giúp bạn dễ dàng thấy được những sản phẩm từ bạn bè trên facebook</small>
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
				<small>Bạn muốn mua những sản phẩm mới nhất, gần mình nhất và đa dạng để lựa chọn. Chức năng tìm kiếm đơn giản của iTake giúp bạn dễ dàng kiếm những thứ mình cần</small>
			</div>
		</div>
	</div>
	<div class="row-fluid intro_item">
		<h1 class="center title_font">Bán được dễ dàng</h1>
		<div class="span3 offset1">
			<h2 class="center">
				<span class="icon-stack icon-2x green">
				  <i class="icon-circle icon-stack-base"></i>
				  <i class="icon-signal icon-light"></i>
				</span>
			</h2>
			<h4 class="center intro_font">BÁN ĐƯỢC NHIỀU HƠN</h4>
			<div class="row center">
				<small>iTake sẽ đưa sản phẩm của bạn đến hàng triệu người mua tìm kiếm ở bất kỳ đâu từ máy tính, máy tính bảng hay điện thoại</small>
			</div>
		</div>
		<div class="span3">
			<h2 class="center" >
				<span class="icon-stack icon-2x green">
				  <i class="icon-circle icon-stack-base"></i>
				  <i class="icon-upload-alt icon-light"></i>
				</span>
			</h2>
			<h4 class="center intro_font">3 CLICK ĐỂ BÁN HÀNG</h4>
			<div class="row center">
				<small>Không cần phải làm một trang web, không phải cập nhật sản phẩm trên facebook hằng ngày. Chỉ cần 3 Click trên iTake sản phẩm của bạn sẽ tự được đưa lên tất cả 3 nơi bao gồm facebook, ứng dụng mobile và trang thông tin trên iTake</small>
			</div>
		</div>
		<div class="span3">
			<h2 class="center">
				<span class="icon-stack icon-2x green">
				  <i class="icon-circle icon-stack-base"></i>
				  <i class="icon-bar-chart icon-light"></i>
				</span>
			</h2>
			<h4 class="center intro_font">PHÂN TÍCH HIỆU QUẢ KINH DOANH</h4>
			<div class="row center">
				<small> iTake sẽ gửi báo cáo hàng tuần đến bạn các thống kê từ lượt view, click, like, share,….. Giúp bạn có thể điều chỉnh chiến lược để bán hàng tốt hơn</small>
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
                'class'=>'btn btn-large btn-primary wide'
            )); ?>
			<?php echo CHtml::link('Đăng ký ngay',array('/user/register'),array(
                'class'=>'btn btn-success btn-large wide'
            )); ?>
            
            
		</div>		
	</div>
</div>
