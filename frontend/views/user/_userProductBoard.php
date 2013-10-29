<?php
$script = <<<HERE
var page = 1;      
var stopLoad = false;        
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
        
    setInterval(function(){
        $('#userProductBoard').isotope('reLayout');
    },500);
        
    initCheckBottom(function(){
        if(false == stopLoad){
            showMessage('Đang lấy thêm sản phẩm...',1000);
            page++;
            $.ajax({
                url:BASE_URL + '/user/userProductList',
                data:{
                    page:page,
                    userId:user.id
                },
                success:function(jsons){
                    var data = $.parseJSON(jsons);
                    if(data.success){
                        if(data.msg.count > 0){                        
                            board.isotope('insert',$(data.msg.items));                 
                        }else{
                            stopLoad = true;
                            showMessage("Không còn sản phẩm nào nữa để tải");
                        }

                    }
                }
            });
        }else{
            showMessage("Không còn sản phẩm nào nữa để tải");
        }        
    });
   
   
});
HERE;
Yii::app()->clientScript->registerScript('userProductList', $script, CClientScript::POS_END);
?>
<div id="userProductBoard" class='productBoard margin-top-20'>
    <?php foreach ($productList as $userProduct): ?>        
        <?php echo $userProduct->renderHtml("", true); ?>        
    <?php endforeach; ?>
</div>
<?php
echo CHtml::link(
        'Next', array(
    '/user/userProductList',
    'userId' => $user->id,
    'page' => $page
        ), array(
    'class' => 'currentUserProductLink',
    'style' => 'display:none'
));
echo CHtml::link(
        'current', 
        array(
            '/user/userProductList',
            'userId' => $user->id,
            'page' => $page + 1
        ), array(
            'class' => 'nextUserProductLink',
            'style' => 'display:none'
        )
);
;
?>