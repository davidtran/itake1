$(document).ready(function() {    
    if(typeof(canChangeSlug)!='undefined' && canChangeSlug){
        $('#slugDialog').modal({
            show:true,
            backdrop:'static'
        });
        
        $('input[name="slug"]').bind('keyup keydown keypress change',function(){
            value = $(this).val();
            $('#newSlug').html(value);
        });
        
        $('#btnSaveSlug').click(function(e){
            e.preventDefault();            
            $.ajax({
                url:BASE_URL + '/user/changeSlug',
                type:'post',
                data:{
                    slug:$('input[name="slug"]').val()
                },
                success:function(json){
                    var data = $.parseJSON(json);
                    if(data.success){
                        bootbox.alert(data.msg,function(){
                            window.location.reload();
                        });
                        $('#slugDialog').modal('hide');
                    }else{
                        bootbox.alert(data.msg);
                    }
                    
                }
            })
            return false;
        });
    }
    var avatarChanger = document.getElementById('avatarChanger');
    if (avatarChanger != undefined) {
        upclick(
                {
                    element: avatarChanger,
                    action: BASE_URL + '/user/uploadProfileImage',
                    dataname: 'profileImage',
                    oncomplete:
                            function(response_data)
                            {
                                var data = $.parseJSON(response_data);
                                if (data.success) {
                                    $('.avatar img').attr('src', data.msg);
                                    $('div.btn-group.user-bar.avatar-bar img').attr('src', data.msg);
                                } else {
                                    alert(data.msg.error);
                                }
                            }
                }
        );
    }


    var bannerChanger = document.getElementById('bannerChanger');
    if (bannerChanger != undefined) {
        upclick(
                {
                    element: bannerChanger,
                    action: BASE_URL + '/user/uploadBannerImage',
                    dataname: 'bannerImage',
                    onstart:
                            function(filename)
                            {
                                
                            },
                    oncomplete:
                            function(response_data)
                            {
                                var data = $.parseJSON(response_data);
                                if(data.success){
                                    $('.top').css({
                                        'background-image':'url("'+data.msg+'")'
                                    });
                                }
                                
                            }
                }
        );
    }
    $container = $('#userProductBoard');
    $container.imagesLoaded(function(){        
        masoryCenterAlign();
        $container.show('fade');
        //have to call 2 times for relayout correctly
        $('#userProductBoard').isotope('reLayout');                   
    });
})