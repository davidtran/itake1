<div class="row-fluid" id="comment-container-parent">
	<?php foreach($comments as $comment): ?>
	<?php $this->renderPartial('partial/_comment_item',array('model'=>$comment))?>
	<?php endforeach; ?>
</div>
