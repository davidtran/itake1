<div class='productRatingContainer'>
	<div class='pull-left'>
		<?php 
			$id = 'productRating-'.rand(0,99999);
			$user = Yii::app()->user->getModel();
			$isStarReadOnly = $user!=null && Rating::isUserRatedProduct($user->id,$product->id);
			$value = Rating::getAverageScoreForProduct($product->id);
			$this->widget('CStarRating',array(
			    'name'=>'rating',
			    'id'=>$id,
			    'callback'=>"js:function(value){
			    	var that = $(this);
			        $.ajax({
			        	url:BASE_URL + '/product/rating',
			        	type:'post',
			        	data:{
			        		value:value
			        	},
			        	success:function(jsons){
			        		var data = $.parseJSON(jsons);
			        		if(data.success){
			        			that.rating(data.msg.averageScore);
			        		}else{
			        			bootbox.alert(data.msg);
			        		}
			        	}
			        });
			    }"
			    'readOnly'=> $isStarReadOnly,
			    'value'=> Rating::getAverageScoreForProduct($product->id)
			)); 
		?>
	</div>
	<div class='starCountContainer pull-left'>
	 	<?php $userCount = Rating::getTotalUserCountForProduct($product->id); ?>	 		
	 	<?php if($userCount > 0):?>
	 		<div class='nonEmptyStar'>
	 			<div class='starCount'><?php echo $userCount;?></div> người đánh giá
	 		</div>	 		
	 	<?php else:?>
	 		<div class='emptyStar'>
	 			Hãy trở thành người đầu tiên đánh giá sản phẩm này
	 		</div>
	 		
	 	<?php endif; ?>
	</div>
</div>
