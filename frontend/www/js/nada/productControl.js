$(document).ready(function(){
    $('.productItem').live('mouseenter',function(){
        $(this).find('.productControl').fadeIn('fast');
        
    });
    $('.productItem').live('mouseleave',function(){
        $(this).find('.productControl').fadeOut('fast');
        
    });
    
    $('.p-delete').live('click',function(e){
        e.preventDefault();
        if(confirm('Bạn có muốn xóa sản phẩm này ?')){
            productItem = $(this).parents('.productItem');
            productId = productItem.attr('data-product-id');
            $.ajax({
                url:BASE_URL + '/upload/delete',
                data:{
                    id:productId
                },
                type:'post',
                success:function(jsons){                    
                    var json = $.parseJSON(jsons);
                    if(json.success){
                        removeProductItemFromBoard(productItem);
                    }else{
                        alert(json.msg);
                    }
                }
            });
        }
        return false;
    });
});

function removeProductItemFromBoard(productItem){
    var board = productItem.parents('.productBoard');
    productItem.fadeOut(100,function(){
        board.isotope('reLayout');
    });
    location.reload();
}

