<div class="row-fluid" id="comment-container">
	<?php foreach($comments as $comment): ?>
	<?php $this->renderPartial('partial/_comment_item',array('model'=>$comment))?>
	<?php endforeach; ?>
</div>
<?php if ($product->commentCount > 5):?>
<div class="row-fluid">
	<a class="btn btn-warn center span12" href="#" id="commentLoadMore" product_id="<?php echo $product->id; ?>">
		Xem thêm ...
	</a>
</div>
<?php endif; ?>

