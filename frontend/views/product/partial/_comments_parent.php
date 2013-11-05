<div class="row-fluid" id="comment-container-parent">
	<?php foreach($model->parentModel as $comment): ?>
	<?php $this->renderPartial('partial/_comment_item',array('model'=>$comment))?>
	<?php endforeach; ?>
</div>
<?php if ($model->childCommentCount > 5):?>
<div class="row-fluid">
	<a class="btn btn-warn center span12" href="#" id="commentChildLoadMore_<?php echo $model->id; ?>" parent_id="<?php echo $model->id; ?>">
		Xem thêm ...
	</a>
</div>
<?php endif; ?>
