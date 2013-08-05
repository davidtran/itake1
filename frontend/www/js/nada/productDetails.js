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
        if(detectmob()||isIE)
            location.href = link;

        return false;
    });

    $('#userProductContainer').height($('#mainProductInfo').height());

    commentWidth = $('#commentContainer').width();

    
});
$(document).live("facebook:ready", function(){
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

                $('.modal-scrollable').scrollTop(0); // work only in modal
                $('body').scrollTop(0); // work in single page
                if ($dialog.css('display') == 'none') {
                    $dialog.modal({
                        show: true,
                        modalOverflow: true
                    });
                }

                //  loadRelateProduct(product);         

                $dialog.on('shown', function() {   
                    $('.slim-scroll').each(function() {
                        var $this = $(this);
                        $this.slimScroll({
                            height: $this.data('height') || 100,
                            railVisible: true,
                            color: '#0A6DFF',
                            alwaysVisible:false,
                        });
                    });
                    addthis.toolbox('.addthis_toolbox');
                    $('#btnShowMap').live('click', function(e) {
                        e.preventDefault();
                        if (loadedMap == false) {
                            loadProductMap(product);
                            loadedMap = true;
                        }

                        return false;
                    });                          
                     $('#userProductList').imagesLoaded(function(){                              
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

function setCommentFullWidth(){
    FB.XFBML.parse(document.getElementById('productDialog'),function(){
        $('.fb-comments iframe,.fb-comments span:first-child').css({'width':$('.fb-comments').width()});
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
        lat: product.lat,
        lng: product.lon,
        width: 300,
        height: 300,
        zoom: 15
    });
    map.addMarker({
        lat: product.lat,
        lng: product.lon,
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
