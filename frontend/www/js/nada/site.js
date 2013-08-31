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
          }
          else{
            $('.selectedCategoryTab').css('background','rgba(0,0,0,0.0)');
              $('.selectedCategoryTab h1').css('color','#0088cc');
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
    $('#selectLocation').click(function(e){
        e.preventDefault();
        if(user == undefined){
            $.ajax({
                url:BASE_URL + '/site/locationDialog',
                type:'post',
                success:function(jsons){
                    var data = $.parseJSON(jsons);
                    if(data.success){
                        $('body').append(data.html);                        
                    }else{
                        bootbox.alert(data.msg);
                    }
                }
            });
        }else{
            window.location = 'login.html';
        }
        $('#locationDialog').modal('show');
        return false;
    });
    
    $('#saveLocation').click(function(e){
        e.preventDefault();
        $.ajax({
            url:BASE_URL + '/site/saveLocation',
            type:'post',
            success:function(jsons){
                var data = $.parseJSON(jsons);
                if(data.success){
                    window.location = data.url;
                }else{
                    bootbox.alert(data.msg);
                }
            }
        });
        return false;
    })
});

