<?php 
$value = Rating::getAverageScoreForProduct($product->id);
$user = Yii::app()->user->getModel();
$isStarReadOnly = $user==null;
$isStarReadOnlyJs = $isStarReadOnly ?'true':'false';
$id = 'productRating-'.rand(0,99999);
$id = 'productStarRating-'.$product->id;
$bigStarUrl = Yii::app()->baseUrl.'/js/jrating/icons/stars.png';
$smallStarUrl = Yii::app()->baseUrl.'/js/jrating/icons/small.png';
$script = "
$(document).ready(function(){
	$('#$id').jRating({
		isDisabled:$isStarReadOnlyJs,
		bigStarsPath:'$bigStarUrl',
		smallStarsPath:'$smallStarUrl',
		phpPath:false,
		sendRequest:false,
		rateMax:5,
		onClick : function(element,rate){			
	    	var parent = $(element).parents('.productRatingContainer');			    	
	        $.ajax({
	        	url:BASE_URL + '/product/rating',
	        	type:'post',
	        	data:{
	        		value:rate,
	        		productId:{$product->id},
	        	},
	        	success:function(jsons){
	        		var data = $.parseJSON(jsons);
	        		console.log(data);
	        		if(data.success){			        			
	        			parent.find('.emptyStar').hide();
	        			parent.find('.nonEmptyStar').show();
	        			parent.find('.starCount').html(data.msg.userCount);			        		
	        		}else{
	        			bootbox.alert(data.msg);
	        		}
	        	}
	        });
		},
	})
});
";
Yii::app()->clientScript->registerScript($id,$script,CClientScript::POS_END);
?>
<script type='text/javascript'>
	<?php echo $script; ?>
</script>
<div class='productRatingContainer row-fluid'>
	<div class='span4'>
		
		<div id="productStarRating-<?php echo $product->id; ?>" data-average="<?php echo $value; ?>" data-id="<?php echo $product->id; ?>"></div>
	</div>
	<div class='starCountContainer span8'>
	 	<?php $userCount = Rating::getTotalUserCountForProduct($product->id); ?>	 		

		 	<?php 
		 	$display = 'none;';
		 	if($userCount > 0){
		 		$display = 'block';
		 	}?>
		 		
		 	
	 		<div class='nonEmptyStar' style='display:<?php echo $display; ?>'>
	 			<span class='starCount'><?php echo $userCount;?></span> người đã đánh giá sản phẩm này
	 		</div>	 		
	 		<?php if($userCount == 0):?>
		 		<div class='emptyStar'>
		 			Hãy trở thành người đầu tiên đánh giá sản phẩm này
		 		</div>
	 		
	 		
	 	<?php endif; ?>
	</div>
</div>
