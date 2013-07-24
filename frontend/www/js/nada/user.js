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
})