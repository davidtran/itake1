<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 */
?>
<div class='container-fluid'>
	<div class="row-fluid">
		<div class="span12 center ">
      <div class="avatar">
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
  </div>
		<h1 class="title_font center" style="color:gray;font-size:1.8em;">
			CẬP NHẬT THÔNG TIN TÀI KHOẢN ITAKE
		</h1>
	</div>
	<div class="span8 offset2" id="profile"> 
  	<?php $this->renderPartial('_formProfile',array('model'=>$model)); ?>
	</div>
</div>
