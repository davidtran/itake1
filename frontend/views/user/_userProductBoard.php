<?php 
$script = <<<HERE
$(document).ready(function() {
    var board = $('#userProductBoard');
    board.isotope({
        columnWidth: 10,
        itemSelector: '.productItem',
        masonryHorizontal: {
            rowHeight: 360
        }
    });
    board.isotope('reLayout');    
    board.infinitescroll({
        navSelector: '.nextUserProductListLink',
        nextSelector: '.nextUserProductListLink',
        itemSelector: '.productItem',
        behavior:'local',
        state: {              
            currPage: 0
        },
        loading: {
            finished: undefined,
            finishedMsg: "<em>Chưa có thêm bài đăng vào lúc này.</em>",
            img: BASE_URL + '/images/loading.gif',
            msg: null,
            msgText: "<em>Đang tải</em>",
            selector: '#userProductLoading',
            speed: 'fast',
            start: undefined
        },
        extraScrollPx: 150,
    }, function(newItems){

        setTimeout(function(){
            board.isotope('appended',$(newItems));
            board.isotope('reLayout');    
        },100);
    });
});
HERE;
Yii::app()->clientScript->registerScript('userProductList',$script,  CClientScript::POS_END);
?>
<div id="userProductBoard" style="display:none;" class='productBoard'>
    <?php foreach($productList as $userProduct):?>        
            <?php echo $userProduct->renderHtml(); ?>        
    <?php endforeach; ?>
</div>
<?php echo CHtml::link(
        'Next',
        array(
            '/user/userProductList',
            'userId'=>$user->id,
            'page'=>$page+1
        ),
        array(
            'class'=>'nextUserProductListLink',
            'style'=>'display:none'
        )
); ?>