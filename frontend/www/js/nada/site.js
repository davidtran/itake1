

var $container;
var ms;
var stopLoad=false;
var page=true;
$(document).ready(function(){
    $('.thumbnails li.span3:nth-child(4n+1)').css({clear:'left',marginLeft:0});	
});
$(document).ready(function() {
    if (canShowCityDialog){
        $('#cityDialog').modal({
            show:true,
            backdrop:'static'
        });
    }
    $container = $('#productContainer');
    // initialize
    $container.isotope({
        columnWidth: 30,
        itemSelector: '.productItem',
        transformsEnabled:false,
        straightAcross: {
            rowHeight: 360
        }
    });
    $container.imagesLoaded(function(){
        console.log('loaded image');
        masoryCenterAlign();
        $container.show('fade');
        $('#productContainer').isotope('reLayout');     
        //  setTimeout(function() {
        //       $('#productContainer').isotope('reLayout');
              
        // }, 500);       
         //$container.css('height',$(window).height()*2);
    }); 
    $(window).scroll(function() {
        if( $(window).scrollTop()!=0)
        {
              $('.selectedCategoryTab').css('background','rgba(0,0,0,0.2)');
              $('.selectedCategoryTab h1').css('color','#fff');
               $('.selectedCategoryTab h1').css('background','rgba(0,0,0,0)');
          }
          else{
            $('.selectedCategoryTab').css('background','rgba(0,0,0,0.0)');
              $('.selectedCategoryTab h1').css('color','#0088cc');
               $('.selectedCategoryTab h1').css('background','#f6f6f6');
          }
    });    
    
    initCheckBottom(function(){
        if(false == stopLoad){
            page++;
            $.ajax({
                url:BASE_URL + '/site/index',
                data:{
                    category:category,
                    keyword:keyword,
                    status:status,
                    city:city,
                    facebook:facebook,
                    page:page
                },
                success:function(jsons){
                    var data = $.parseJSON(jsons);
                    if(data.success){
                        if(data.msg.count > 0){                        
                            $container.isotope('insert',$(data.msg.items));                            
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
// setInterval(function(){
//     $('#productContainer').isotope('reLayout');
// },500);

$(document).ready(function(){
    
    
    
});

