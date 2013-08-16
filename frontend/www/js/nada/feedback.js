var FeedbackForm = {
    formSelector:'#feedbackForm',
    showDialogButtonSelector:'#btnShowFeedbackDialog',
    dialogSelector:'#feedbackDialog',
    sendFeedbackButtonSelector:'#btnSendFeedback',
    dialog:null,
    init:function(){
        FeedbackForm.initShowDialogButton();
        FeedbackForm.initSendButton();
    },
    initShowDialogButton:function(){
        $(FeedbackForm.showDialogButtonSelector).click(function(e){
            e.preventDefault();
            $.ajax({
                url:ABSOLUTE_URL + '/feedback/index',
                type:'post',
                success:function(jsons){
                    var data = $.parseJSON(jsons);
                    if(data.success){
                        FeedbackForm.dialog = $(data.msg.html);
                        $('body').append(FeedbackForm.dialog);
                        $('#scrollUp').hide();
                        $('#btnShowFeedbackDialog').hide();;
                        FeedbackForm.dialog.modal('show');  
                        FeedbackForm.dialog.on('hide',function() {                       
                             $('#btnShowFeedbackDialog').show();
                        });
                    }
                }
            });
            return false;
        });
    },    
    initSendButton:function(){
        //send feedback in ajax dialog, so we use live function
        $(FeedbackForm.sendFeedbackButtonSelector).live('click',function(e){
            e.preventDefault();
            var that = $(this);
            that.button('loading');
            data = $(FeedbackForm.formSelector).serializeObject();
            FeedbackForm.sendFeedback(data,function(result){
                bootbox.alert(result.msg);                
                if(result.success){
                    FeedbackForm.dialog.modal('hide');
                }
            });
            return false;
        });
    },
    sendFeedback:function(data,callback){
        callback = callback || function(){};
        $.ajax({
            url:ABSOLUTE_URL + '/feedback/send',
            type:'post',
            data:data,
            success:function(jsons){
                var data = $.parseJSON(jsons);
                callback(data);
            }
        });
    }   
};

$(document).ready(function(){
    FeedbackForm.init();
});