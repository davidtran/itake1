<div class="row-fluid">
	<div class="comment_item" id="comment_id_<?php echo $model->id; ?>">
		<div class="pull-left">
			<?php  
			echo UserImageUtil::renderImage($model->user,array(
	                        'width' => 30,
	                        'height' => 30,
	                        'style' => 'width: 30px;
	                                          height: 30px;',
	                        'class' => 'img-circle',
	                    ));
	              ?>
           </div>
         <div class="pull-left">
			<div class="content">
				<p><?php echo nl2br(CHtml::encode($model->content)); ?></p>
			</div>
			<?php if($model->parent_id==NULL): ?>
			<a href="#" class="parent" parent_id="<?php $model->id ?>" >Reply</a>
			<div id="comment_id_<?php echo $model->id; ?>">
				<div class="form-comment-child"  style="display:none;">
				<?php 

					$modelparent = new Comment; 
					$modelparent->product_id = (int)$model->product_id;
					$modelparent->parent_id = (int)$model->id;

				?>
				<?php 
					$this->renderPartial('partial/_frmparent',array(
                            'model'=>$modelparent,
                    )); 
				 ?>
				 <?php 
				 	// var_dump($model->parentModel);
				 	// die;
				 	$this->renderPartial('partial/_comments_parent',array(
                            // 'product'=>$product,
                            'comments'=>$model->parentModel,
                        )); 
				  ?>
				</div>
				

			</div>
		<?php endif; ?>
			<div class="time">
				<small><?php echo ($model->displayDateTime()); ?></small>
			</div>
		</div>

	</div><!-- comment -->
</div>