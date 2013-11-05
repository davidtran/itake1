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
			<?php if(UserUtil::canEdit($model->user)):	
			?>
			<a href="#" class="deletecomment" id="del-comment-<?php echo $model->id ?>" comment_id="<?php echo $model->id ?>" >Del</a>
			<?php endif; ?>
			<?php if($model->parent_id==0): ?>
			<a href="#" class="replycomment" id="comment-child-<?php echo $model->id ?>" replyId = "<?php echo $model->id ?>">Reply</a>
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
                            'model_id'=>$model->id,
                    )); 
				 ?>
				
				</div>
				<div class="form-comment-child">
					 <?php 
				 	// var_dump($model->parentModel);
				 	// die;
				 	$this->renderPartial('partial/_comments_parent',array(
                            // 'product'=>$product,
                            'model'=>$model,
                            
                        )); 
				  ?>
				</div>

			</div>
		<?php endif; ?>
			<div class="time">
                <small><?php echo DateUtil::displayTime($model->create_date); ?></small>
			</div>
		</div>

	</div><!-- comment -->
</div>