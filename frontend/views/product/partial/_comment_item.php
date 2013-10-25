<div class="row-fluid">
	<div class="comment_item" id="c<?php echo $model->id; ?>">
		<div class="pull-left">
			<?php  
			// echo UserImageUtil::renderImage($model->user,array(
	  //                       'width' => 30,
	  //                       'height' => 30,
	  //                       'style' => 'width: 30px;
	  //                                         height: 30px;',
	  //                       'class' => 'img-circle',
	  //                   ));
	              ?>
           </div>
         <div class="pull-left">
			<div class="content">
				<p><?php echo nl2br(CHtml::encode($model->content)); ?></p>
			</div>
			<div class="time">
				<small><?php echo ($model->displayDateTime()); ?></small>
			</div>
		</div>

	</div><!-- comment -->
</div>