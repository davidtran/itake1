var urlHome = 'http://' + document.location.hostname;
if (urlHome.indexOf('localhost') != -1)
{
    urlHome += "/nada/";
}
var urlHomeSite = urlHome + "site";
var viewCounter = 0;
function initZoomProduct() {
    if ($('#imagePreview').size() > 0)
    {
        console.log('initZoomProduct');
        $("#imagePreview").elevateZoom({
            zoomWindowWidth: $('.bs-docs-example').width(),
            zoomWindowHeight: $('.bs-docs-example').height(),
            borderSize: 1,
            borderColor: "#fff",
            zoomWindowOffetx: ($('.bs-docs-example').position().left - $('.bs-docs-example').width()) / 3
        });
    }
}
$(window).resize(function() {
    alignDiv();
});
$(document).ready(function() {
    $('.slim-scroll').each(function() {
        var $this = $(this);
        $this.slimScroll({
            height: $this.data('height') || 100,
            railVisible: true
        });
    });
    alignDiv();
    initZoomProduct();
});
function alignDiv()
{
    console.log('Align....');
    $('.fb-comments span').width('100%');
    commentWidth = $('.fb-comments span').width();
    $('.fb-comments').attr('data-width', commentWidth);
    var marginLeftContainer = ($('body').width() - $('#productContainer').width()) / 2 + $('#productContainer').width() * 0.06;
    var marginLeftContainer2 = ($('body').width() - $('#userProductBoard').width()) / 2 + $('#userProductBoard').width() * 0.06;
    var marginLeftContainer3 = ($('body').width() - $('#categories-bar').width()) / 2;
    if (marginLeftContainer * 2 != $('body').width())
    {
        $('#productContainer').css('margin-left', marginLeftContainer + 'px');
        $('#categories-bar').css('margin-left', (marginLeftContainer3) + 'px');
    }
    if (marginLeftContainer2 * 2 != $('body').width()) {
        $('#userProductBoard').css('margin-left', marginLeftContainer2 + 'px');
        $(".nd_profile").css('margin-left', marginLeftContainer2 + 'px');
        $(".nd_profile").css('margin-right', (marginLeftContainer2 - 15) + 'px');
    }
     $('#productContainer').isotope('reLayout');
//     $('.nav-bar-top').css('width', $('body').width() + 'px');
}
$(function() {
    // Create the measurement node
    var scrollDiv = document.createElement("div");
    scrollDiv.className = "scrollbar-measure";
    document.body.appendChild(scrollDiv);

// Get the scrollbar width
    var scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth;
    console.warn(scrollbarWidth); // Mac:  15
// Delete the DIV 
    document.body.removeChild(scrollDiv);
    // Prepare
    var History = window.History; // Note: We are using a capital H instead of a lower h
    if (!History.enabled) {
        // History.js is disabled for this browser.
        // This is because we can optionally choose to support HTML4 browsers or not.
        return false;
    }
    window.onpopstate = function(event) {
        console.log("location: " + document.location + ", state: " + JSON.stringify(event.state));
    };
    // Bind to StateChange Event
    History.Adapter.bind(window, 'statechange', function() { // Note: We are using statechange instead of popstate
        var State = History.getState();
        History.log(State.data, State.title, State.url);
        if (isProductDetailUrl(State.url))
        {
            if ($dialog == null)
            {
                location.href = State.url;
            }
            if ($dialog.css('display') == 'none' && State.data.productIdHtml != undefined
                    && $dialog.find('#userProductList') != undefined && $dialog.attr('data-item-id') == State.data.productIdHtml) {
                $dialog.modal({
                    show: true,
                    modalOverflow: true
                });
            }
            return false;
        }
        if (location.href == urlHomeSite || location.href == urlHome || location.href.indexOf('user/profile/') != -1)
        {
            if ($dialog.css('display') != 'none' && State.data.productIdHtml == undefined) {
                viewCounter--;
                $dialog.modal('hide');
            }
        }
        else
        {

        }
        //$('#content').load(State.url);
    });

    $('.productLink').live('click', function(e) {
        e.preventDefault();
        link = $(this).attr('href');
        productItem = $(this).parents('.productItem');
        productId = productItem.attr('data-product-id');
        productIdHtml = productItem.attr('id');
        //loadProduct(link,productIdHtml);                
        History.pushState({
            productIdHtml: productIdHtml,
            dlgPush: true
        }, getUrlQuery(link, 'title'), link);
        viewCounter++;
        return false;
    });

    $(document).ready(function() {
        $('.slim-scroll').each(function() {
            var $this = $(this);
            $this.slimScroll({
                height: $this.data('height') || 100,
                railVisible: true
            });
        });       
        if (!isProductDetailUrl(location.href))
        {
            History.replaceState({}, document.title, location.href);

        }
        $dialog = $('#productDialog');
        if ($dialog != undefined)
        {
            $dialog.on('shown', function() {

            });
            $dialog.on('hidden', function() {
                var tempCounter = viewCounter;
                viewCounter = 0;
                if (tempCounter != 0)
                    History.go(-tempCounter);
            });
        }
        // scrollables        
    });
});
function isProductDetailUrl(s)
{
    var regexPatterns = /product\/details\/\d*\?title=/i;
    return s.match(regexPatterns) != null && s.match(regexPatterns).length > 0;
}


function facebookCommentsAttachment()
{
    var fbCommentEle = document.getElementById('fb-comments-product');
    if (fbCommentEle != null)
    {
        $('#fb-comments-product').html('');
        var fb_p_width = fbCommentEle.offsetWidth;
        $('#fb-comments-product').html('<div class="fb-comments" style="margin-top: 15px;" data-href="' + document.location.href + '" data-width="' + fb_p_width + '" data-num-posts="5"></div>');
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id))
                return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=620447237967845";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    }
}


function getUrlQuery(href, qr)
{
    var vars = [], hash;
    var hashes = href.slice(href.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars[qr];
}
function utf8_decode(str_data) {

    // http://kevin.vanzonneveld.net
    // +   original by: Webtoolkit.info (http://www.webtoolkit.info/)
    // +      input by: Aman Gupta
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Norman "zEh" Fuchs
    // +   bugfixed by: hitwork
    // +   bugfixed by: Onno Marsman
    // +      input by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: kirilloid
    // *     example 1: utf8_decode('Kevin van Zonneveld');
    // *     returns 1: 'Kevin van Zonneveld'

    var tmp_arr = [],
            i = 0,
            ac = 0,
            c1 = 0,
            c2 = 0,
            c3 = 0,
            c4 = 0;

    str_data += '';

    i = 0;
    tmp_arr = [];
    vars = [];
    qr = null;


    while (i < str_data.length) {

        c1 = str_data.charCodeAt(i);
        if (c1 <= 191) {
            tmp_arr[ac++] = String.fromCharCode(c1);
            i++;
        } else if (c1 <= 223) {
            c2 = str_data.charCodeAt(i + 1);
            tmp_arr[ac++] = String.fromCharCode(((c1 & 31) << 6) | (c2 & 63));
            i += 2;
        } else if (c1 <= 239) {
            // http://en.wikipedia.org/wiki/UTF-8#Codepage_layout
            c2 = str_data.charCodeAt(i + 1);
            c3 = str_data.charCodeAt(i + 2);
            tmp_arr[ac++] = String.fromCharCode(((c1 & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
            i += 3;
        } else {
            c2 = str_data.charCodeAt(i + 1);
            c3 = str_data.charCodeAt(i + 2);
            c4 = str_data.charCodeAt(i + 3);
            c1 = ((c1 & 7) << 18) | ((c2 & 63) << 12) | ((c3 & 63) << 6) | (c4 & 63);
            c1 -= 0x10000;
            tmp_arr[ac++] = String.fromCharCode(0xD800 | ((c1 >> 10) & 0x3FF));
            tmp_arr[ac++] = String.fromCharCode(0xDC00 | (c1 & 0x3FF));
            i += 4;
        }
    }

    return tmp_arr.join('');
}
function signinCallback(authResult) {
    console.log('Sign in call back')
    if (authResult['access_token']) {
        // Successfully authorized
        // Hide the sign-in button now that the user is authorized, for example:
        document.getElementById('gplusSignIn').setAttribute('style', 'display: none');
    } else if (authResult['error']) {
        // There was an error.
        // Possible error codes:
        //   "access_denied" - User denied access to your app
        //   "immediate_failed" - Could not automatically log in the user
        // console.log('There was an error: ' + authResult['error']);
    }
}
function disconnectUser(access_token) {
    var revokeUrl = 'https://accounts.google.com/o/oauth2/revoke?token=' +
            access_token;

    // Perform an asynchronous GET request.
    $.ajax({
        type: 'GET',
        url: revokeUrl,
        async: false,
        contentType: "application/json",
        dataType: 'jsonp',
        success: function(nullResponse) {
            // Do something now that user is disconnected
            // The response is always undefined.
        },
        error: function(e) {
            // Handle the error
            // console.log(e);
            // You could point users to manually disconnect if unsuccessful
            // https://plus.google.com/apps
        }
    });
}
function render() {
    gapi.signin.render('gplusSignIn', {
        //'callback': 'signinCallback',
        'clientid': '933964749471.apps.googleusercontent.com',
        'cookiepolicy': 'single_host_origin',
        'requestvisibleactions': 'http://schemas.google.com/AddActivity',
        'scope': 'https://www.googleapis.com/auth/plus.login'
    });
}

Number.prototype.formatMoney = function(c, d, t){
var n = this, 
    c = isNaN(c = Math.abs(c)) ? 2 : c, 
    d = d == undefined ? "." : d, 
    t = t == undefined ? "," : t, 
    s = n < 0 ? "-" : "", 
    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
    j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};