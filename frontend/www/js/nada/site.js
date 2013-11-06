

var $container;
var ms;
var stopLoad=false;
var page=0;
var columns = null;

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
        transformsEnabled:true,        
        straightAcross: {
            rowHeight: 360
        }
    });
        
    
   $container.imagesLoaded(function(){        
        $container.show('fade');
         $(window).smartresize(function(){
    // check if columns has changed
    var currentColumns = Math.floor( (  $container.width()) / (250+0.02* $container.width()) );
    if ( currentColumns !== columns ) {
      // set new column count
      columns = currentColumns;
      // apply width to container manually, then trigger relayout
        var fixWidth = columns * 250+(columns-1)*$container.width()*0.03;
      $container.width(fixWidth)
        .isotope('reLayout');   
    }
    
  }).smartresize();
       // $container.isotope('reLayout');
//        setInterval(function(){
//            $container.isotope('reLayout');
//        },500);
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
            showMessage('Đang lấy thêm sản phẩm...',1000);
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
                            showMessage("Không còn sản phẩm nào nữa để tải",1000);
                        }

                    }
                }
            });
        }else{
            showMessage("Không còn sản phẩm nào nữa để tải");
        }        
    });
    
});
