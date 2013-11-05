var $container;
var ms;
var userProductPage = 1;
var $side;
var $dialog;
var $relateProductContainer;
var justLoadProduct = false;
var noReloadProduct = false;
requestHide = false;
requestShow = false;
var currentHref;
var currentProduct;
var loadedMap = false;
var product;

$(document).ready(function() {
    $('#special').hide();
    $dialog = $('#productDialog');
    commentRegisterEventSubmit();
    $relateProductContainer = $('#relateProductList');
    $side = $('#userProductList');
    $userProductList = $('#userProductList');
    $('.productImageLink, .product-detail').live('click', function(e) {      
        if(!detectMobile()){
            e.preventDefault();
            link = $(this).find('.productLink').attr('href');     
            productItem = $(this).parents('.productItem');
            productId = productItem.attr('data-product-id');
            productIdHtml = productItem.attr('id');
            productTitle = productItem.attr('data-title');
            //loadProduct(link,productIdHtml);
            History.pushState({
                productIdHtml: productIdHtml,
                dlgPush: true
            }, productTitle, link);
            return false;
        }
        return true;
    });
  

    $('#userProductContainer').height($('#mainProductInfo').height());
    commentWidth = $('#commentContainer').width();
    loadImageSlider();
    loadImageSlideShow();
});
$(document).live("facebook:ready", function() {
    setCommentFullWidth();
});

function productClick() {

}
function startLoadingBackground(productItem) {
    productItem.css({
        opacity: 0.7
    });
    productItem.append('<div id="loadingProductBackground"><i class="icon-spinner icon-spin icon-3x"></i></div>');
}
function stopLoadingBackground(productItem) {
    productItem.css({
        opacity: 1
    });
    $('#loadingProductBackground').remove();
}
function decode_utf8(s) {

    return decodeURIComponent(escape(s));

}
function scrollToTopDialog()
{
    $('.modal-scrollable').scrollTop(0);
}
function loadProduct(href, htmlProductId)
{

    //$('#scrollUp').hide();
    // $('#btnShowFeedbackDialog').hide();
    $('#scrollUp').hide();

    //where 1: home 2: user product 3:relateProduct    
    currentHref = href;
    isLoadingNew = true;
    //load html
    //load product data
    //show dialog      
    productItem = $('#' + htmlProductId);
    startLoadingBackground(productItem);
    $('#special').show();
    $.ajax({
        url: href,
        type: 'get',
        error: function()
        {

        },
        success: function(jsons)
        {
            var json = $.parseJSON(jsons);
            if (json.success)
            {
                noReloadProduct = true;
                if (isIE) {
                    document.location.href = href;
                    return;
                }
                $dialog.attr('data-item-id', htmlProductId);
                $('#productDialogBody').html('');
                $('#productDialogBody').html(utf8_decode(json.msg.html));
                $relateProductContainer = $('#relateProductList');
                $userProductList = $('#userProductList');
                product = json.msg.product;
                currentProduct = product;

                loadUserProduct(product);
                loadImageSlideShow();
                commentRegisterEventSubmit();
                //$('.modal-scrollable').scrollTop(0); // work only in modal
                //$('body').scrollTop(0); // work in single page
                if ($dialog.css('display') == 'none') {
                    $dialog.modal({
                        show: true,
                        modalOverflow: true
                    });
                }

                //  loadRelateProduct(product);         
                $('.modal-scrollable').scroll(function(event) {

                    if($('.modal-scrollable').scrollTop()==0)
                    {
                        $('.scrollUp_tag').hide();
                    }
                    else{
                        $('.scrollUp_tag').show();
                    }
                });
                if ($dialog.css('display') != 'none') {
                    loadImageSlider();
                }
                $dialog.on('shown', function() {
                    trackingLink(href);
                    loadImageSlider();
                    $('.slim-scroll').each(function() {
                        var $this = $(this);
                        $this.slimScroll({
                            height: $this.data('height') || 100,
                            railVisible: true,
                            color: '#0A6DFF',
                            alwaysVisible: false,
                        });
                    });
                    loadImageSlideShow();
                    addthis.toolbox('.addthis_toolbox');
                    $('#btnShowMap').live('click', function(e) {
                        e.preventDefault();
                        if (loadedMap == false) {
                            loadProductMap(product);
                            loadedMap = true;
                        }

                        return false;
                    });
                    $userProductList.imagesLoaded(function() {
                        masoryCenterAlign();
                        $userProductList.show('fade');
                        $userProductList.isotope('reLayout');
                        setTimeout(function() {
                            $userProductList.isotope('reLayout');
                        }, 200);
                    });
                });
                $dialog.on('hidden', function(e) {
                    $(".zoomContainer").remove();
                    $('#special').hide();
                    $dialog.find('#productDialogBody').empty();
                });
            }
        },
        complete: function() {
            stopLoadingBackground(productItem);
            setCommentFullWidth();
        }
    });
}

function setCommentFullWidth() {
    FB.XFBML.parse(document.getElementById('productDialog'), function() {
        $('.fb-comments iframe,.fb-comments span:first-child').css({'width': $('.fb-comments').width()});
    });
}
function loadRelateProduct(product) {
    $('#relateProductList').isotope({
        columnWidth: 28,
        itemSelector: '#relateProductList .productItem',
        transformsEnabled: false,
        masonryHorizontal: {
            rowHeight: 360
        }
    });

    setTimeout(function() {
        $('#relateProductList').isotope('reLayout');
    }, 500);
}

function loadProductMap(product) {
    var map = new GMaps({
        div: '#map',
        lat: product.address.lat,
        lng: product.address.lon,
        width: 300,
        height: 300,
        zoom: 15
    });
    map.addMarker({
        lat: product.address.lat,
        lng: product.address.lon,
        title: product.locationText
    });
    currentProduct = product;
}

function loadUserProduct(product) {
    $userProductList.isotope({
        columnWidth: 28,
        itemSelector: '.productItem',
        transformsEnabled: false,
        masonryHorizontal: {
            rowHeight: 360
        }
    });
    setTimeout(function(){
        $userProductList.isotope('reLayout');
    },500);
    setTimeout(function(){
        $userProductList.isotope('reLayout');
    },1500);
}
function loadImageSlideShow(){
     $('.popup-gallery').magnificPopup({
        delegate: 'a',
        type: 'image',
        mainClass: 'mfp-img-mobile',
        gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0,1] // Will preload 0 - before current, and 1 after the current image
            },
    });
}
///



//SEND MESSAGE

$(document).ready(function(){
    $('.btnOpenProductMessageDialog').live('click',function(e){
        e.preventDefault();
        var id = $(this).attr('data-product-id');
        var that = $(this);
        $('#sendProductMessageDialog').remove();
        $.ajax({
            url:BASE_URL + '/product/sendMessageDialog',
            type:'post',
            data:{
                productId:id
            },
            success:function(jsons){
                var data = $.parseJSON(jsons);
                if(data.success){
                    $('body').append(data.msg.html);
                    $('#sendProductMessageDialog').modal('show');
                }else{
                    bootbox.alert(data.msg);
                }
            }
        });
        return false;
    });
    
    $('.btnSendProductMessage').live('click',function(e){
        e.preventDefault();
        var id = $(this).attr('data-product-id');
        var that = $(this);
        var formData = $('#productMessageForm').serializeObject();
        $.ajax({
            url:BASE_URL + '/product/sendMessage?productId='+id,
            data:formData,
            type:'post',
            success:function(jsons){
                var data = $.parseJSON(jsons);
                if(data.success){
                    bootbox.alert(data.msg);
                    $('#sendProductMessageDialog').modal('hide');
                }else{
                    bootbox.alert(data.msg);
                    $('#refreshCaptcha').click();
                }
                
                
            }
        });
        return false;
    });
});

function commentRegisterEventSubmit(){
    var CurrentPage = 2;
    var CurrentChildPage =2 ;
		$( "#comment-form" ).submit(function( event ) {
		  // alert( "Handler for .submit() called." );
		  event.preventDefault();
		  var datos = $(this).serialize();
       	 $.post(BASE_URL + "/product/postComment", datos, function(data) {
            $( "#comment-form" )[0].reset();
            var _result = $.parseJSON(data);
            if (_result.error_code == 1) {
                $('#comment-container').prepend(utf8_decode(_result.msg.html));
            } else {
                console.log('error')
            }
            
        });
        return false;

	});
       //load more parent comment
        $( "#commentLoadMore" ).click(function(event) {
          // alert( "Handler for .click() called." )
           event.preventDefault();
           var datos = {product_id: $("#commentLoadMore").attr("product_id"),page:CurrentPage};
           $.get(BASE_URL + "/product/commentLoadMore/", datos, function(data) {
              var _result = $.parseJSON(data);
              if (_result.error_code == 1) {
                  $('#comment-container').append(utf8_decode(_result.msg.html));
                  if(CurrentPage==_result.msg.pageCount)
                  {
                      $( "#commentLoadMore" ).hide('fade');
                  }
                  CurrentPage++;
              } else {
                  console.log('error')
              }
              
           });
           return false;
        });
        //reply
        $( "a[id^='comment-child-']" ).live( "click", function(event) {
            event.stopPropagation();
            $(this).parent().find(".form-comment-child" ).show('fade');
            $(document).live( "click", function() {
            });
            return false;
        });
         $( "a[id^='del-comment-']" ).live( "click", function(event) {
              event.preventDefault();
              var that = $(this);
              if(confirm("Bạn có muốn xóa bình luận này ?")==true){               
                $.get(BASE_URL + "/product/deleteComment/", {
                    comment_id:that.attr('comment_id')
                }, function(json) {
                        var data = $.parseJSON(json);
                        if(data.success){
                            that.parents('.comment_item').hide('fade');
                        }else{
                            bootbox.alert(data.msg);
                        }
                    }
                );
              }
              return false;
          });
      $( "form[id^='farent-form_']" ).live( "submit", function(event) {
        event.preventDefault();
        var datos = $(this).serialize();
        $('#'+$(this).attr('id')).get(0).reset();

           $.post(BASE_URL + "/product/postComment", datos, function(data) {
              var _result = $.parseJSON(data);
              if (_result.error_code == 1) {
                  $('#comment_id_'+_result.msg.parent_id+' #comment-container-parent').prepend(utf8_decode(_result.msg.html));
              } else {
                  console.log('error')
              }

          });
          return false;
     });
      $( "a[id^='commentChildLoadMore_']" ).live('click',function(event) {
           event.preventDefault();
           var parentid = $(this).attr("parent_id");
           var datos = {parent_id:parentid,page:CurrentChildPage};
           $.get(BASE_URL + "/product/commentChildLoadMore/", datos, function(data) {
              var _result = $.parseJSON(data);
              if (_result.error_code == 1) {
                  $('#comment_id_'+ parentid +' #comment-container-parent').append(utf8_decode(_result.msg.html));
                  if(CurrentChildPage==_result.msg.pageCount)
                  {
                      $('#commentChildLoadMore_'+parentid).hide('fade');
                  }
                  CurrentChildPage++;
              } else {
                  console.log('error')
              }
              
           });
           return false;
        });
        
        $('#Comment_content').live('click',function(e){
            e.preventDefault();
            if(typeof(loginUser) =='undefined'){
                url = $(this).parent().find('.commentLoginUrl').val();
                console.log(url);
                window.location = url;
            }
            return false;
        });

}