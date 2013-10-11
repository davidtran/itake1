<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 */
?>
<div class='container-fluid' style='margin-top:54px;'>
	<div class="row-fluid">
		<div class="span12 center">
			 <?php
                                            echo UserImageUtil::renderImage($model,array(
                                            'width' => 70,
                                            'height' => 70,
                                            'style' => 'width: 100px;
                                            height: 100px;',
                                            'class' => 'img-circle',
                                            ));
                                            ?>
		</div>
		<h1 class="title_font center" style="color:gray;font-size:1.8em;">
			CẬP NHẬT THÔNG TIN TÀI KHOẢN ITAKE
		</h1>
	</div>
	<div class="span8 offset2">
		<ul class="nav nav-tabs">
  		<li class="active"><a href="#profile" data-toggle="tab" >Thông tin cơ bản </a></li>
  		<li><a href="#thongke" data-toggle="tab" >Thống kê</a></li>
	</ul>
	<div class="tab-content">
  <div class="tab-pane active" id="profile">
  	<?php $this->renderPartial('_formProfile',array('model'=>$model)); ?>
  </div>
  <div class="tab-pane " id="thongke">
  	...
  </div>
</div>
	</div>
</div>
