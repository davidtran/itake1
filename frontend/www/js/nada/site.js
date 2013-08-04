var $container;
var ms;
$(document).ready(function() {    
    $(function () {
    $.scrollUp({
        scrollName: 'scrollUp', // Element ID
        topDistance: '300', // Distance from top before showing element (px)
        topSpeed: 300, // Speed back to top (ms)
        animation: 'fade', // Fade, slide, none
        animationInSpeed: 200, // Animation in speed (ms)
        animationOutSpeed: 200, // Animation out speed (ms)
        scrollText: '', // Text for element
        activeOverlay: false // Set CSS color to display scrollUp active point, e.g '#00FFFF'
      });
    });    
    $container = $('#productContainer');
    // initialize
    $container.isotope({
        columnWidth: 30,
        itemSelector: '.productItem',
        transformsEnabled:false,
        masonryHorizontal: {
            rowHeight: 360
        }
    });
    $container.imagesLoaded(function(){
        console.log('loaded image');
        masoryCenterAlign();
        $container.show('fade');
        $('#productContainer').isotope('reLayout');            
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
                finishedMsg: "<em>Chưa có thêm bài đăng vào lúc này.</em>",
                img:BASE_URL + '/images/loading.gif',
                msg: null,
                msgText: "<em>Đang tải</em>",
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
            });      
            // setTimeout(function() {
            //     $('#productContainer').isotope('reLayout');
              
            // }, 500);
        }
    );
});

