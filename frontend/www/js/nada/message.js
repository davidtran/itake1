var Message = {
    sendDialog:null,
    init:function(){
        
    },
    initOpenMessageDialogButton:function(){
        $('#btnOpenMessageDialog').click(function(e){
            e.preventDefault();
            var product_id =   $(this).parents('.productItem').attr('data-product-id');
            var receiver_id = $(this).parents('.productItem').attr('data-user-id');
            $.ajax({
                url:BASE_URL + '/message/send',
                data:{
                    receiver_id:receiver_id,
                    product_id:product_id
                },
                success:function(jsons){
                    var json = $.parseJSON(jsons);
                    if(json.success){
                        Message.sendDialog = $(json.msg.html);
                        Message.sendDialog.modal('show');
                    }
                }
            });
            return false;
        });
    },    
    initSendMessage:function(){
        $('#btnSendMessage').live('click',function(e){
            e.preventDefault();
            var form = Message.sendDialog.find('#messageForm');
            $.ajax({
                url:BASE_URL +'/message/send',
                data:form.serializeObject(),
                success:function(jsons){
                    var data = $.parseJSON(jsons);
                    if(data!=null ){
                        if(data.success){
                            bootbox.alert(data.msg);                            
                            Message.sendDialog.modal('hide');                            
                        }else{
                            bootbox.alert(data.msg);
                        }
                    }
                }
            });
            return false;
        });
    },
    showQuickList: function(){

    },
    showConversationWindow: function(){

    }
    
};

$(document).ready(function(){
    Message.init();
})