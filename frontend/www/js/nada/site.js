var $container;
var ms;
$(document).ready(function(){
    $('.thumbnails li.span3:nth-child(4n+1)').css({clear:'left',marginLeft:0});	
});
$(document).ready(function() {
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
    $container.infinitescroll(
        {
            navSelector: '.nextPageLink',
            nextSelector: '.nextPageLink',
            itemSelector: '.productItem',
            state: {              
                currPage: 0
            },
            loading: {
                finished: undefined,
                finishedMsg: "<em>Have no more post at the moment.</em>",
                img:BASE_URL + '/images/loading.gif',
                msg: null,
                msgText: "<em>Loading</em>",
                selector: '#loadingText',
                speed: 'fast',
                start: undefined
            },
            extraScrollPx: 150,
            
        }, 
        function(newItems) {
            $('#productContainer').isotope('appended', $(newItems));      
            $container.imagesLoaded(function(){                
                $('#productContainer').isotope('reLayout');    
                $('#productContainer').isotope('reLayout');          
            });      
            // setTimeout(function() {
            //     $('#productContainer').isotope('reLayout');
              
            // }, 500);
        }
    );
});
// setInterval(function(){
//     $('#productContainer').isotope('reLayout');
// },500);

$(document).ready(function(){
    
    
    
});

