$(document).ready(function() {    
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
        console.log('loaded image');
        masoryCenterAlign();
        $container.show('fade');
        //have to call 2 times for relayout correctly
          $('#userProductBoard').isotope('reLayout');            
          $('#userProductBoard').isotope('reLayout');     
    });
})