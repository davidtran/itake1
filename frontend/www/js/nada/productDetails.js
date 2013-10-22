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
    $relateProductContainer = $('#relateProductList');
    $side = $('#userProductList');
    $('.productLink').live('click', function(e) {
        e.preventDefault();
        link = $(this).attr('href');
        productItem = $(this).parents('.productItem');
        //productId = productItem.attr('data-product-id');
        productIdHtml = productItem.attr('id');
        loadedMap = false;
        if (detectmob() || isIE)
            location.href = link;

        return false;
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
                $side = $('#userProductList');
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
                    $('#userProductList').imagesLoaded(function() {
                        masoryCenterAlign();
                        $('#userProductList').show('fade');
                        $('#userProductList').isotope('reLayout');
                        setTimeout(function() {
                            $('#userProductList').isotope('reLayout');
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
    $('#userProductList').isotope({
        columnWidth: 28,
        itemSelector: '.productItem',
        transformsEnabled: false,
        masonryHorizontal: {
            rowHeight: 360
        }
    });
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