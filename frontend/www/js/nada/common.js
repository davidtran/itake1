//show comment count after ajax call
var $mainNotification = $('.main-notification');
var $notificationSpan = $('.main-notification p span');
$(document).ready(function(){
    $mainNotification = $('.main-notification');
    $notificationSpan = $('.main-notification p span');
    $('body').ajaxComplete(function(){ FB.XFBML.parse(document.body) }); 
});


var isIE = /*@cc_on!@*/false;
var itakeHistoryHandler;
$dialog = $('#productDialog');
if(!isIE)
{
    itakeHistoryHandler = {
    pageContextUrl:location.href.replace(/#.*/,''),
    pageContextTitle:document.title,   
    init:function(){
        var History = window.History; // Note: We are using a capital H instead of a lower h
        if (!History.enabled) {
            // History.js is disabled for this browser.
            // This is because we can optionally choose to support HTML4 browsers or not.
            return false;
        }    
        // Bind to StateChange Event
        var lastUrl;
        History.Adapter.bind(window, 'statechange', function() { // Note: We are using statechange instead of popstate
            var State = History.getState();
             //History.log(State.data, State.title, State.url);
            if(State.url==itakeHistoryHandler.pageContextUrl){            
                if (typeof $dialog!==undefined&&$dialog!=undefined&&$dialog.css('display') != 'none') {                
                    $dialog.modal('hide');
                }
                return;
            }       
            if ($dialog == null)
            {
                location.href = State.url;
            }
            else
            {
                if (lastUrl != State.url&&State.data.productIdHtml == undefined)
                {
                    if ($dialog.css('display') != 'none' && State.data.productIdHtml == undefined) {
                        $dialog.modal('hide');
                    }
                }
                else if (State.data.productIdHtml != undefined)
                {
                    loadProduct(location.href,State.data.productIdHtml);
                }

                $dialog.on('hidden', function() {
                    History.pushState({}, itakeHistoryHandler.pageContextTitle, itakeHistoryHandler.pageContextUrl);
                });

            }
            lastUrl = State.url;
        });
    } 
}
}
var scrollbarWidth;
$(window).resize(function() {
    alignDiv();
});
function loadImageSlider() {
    $('.flexslider').flexslider({
        animation: "slide",
        controlNav: "thumbnails",
        smoothHeight: false
    });
}
$(document).ready(function() {
    if(!isIE)
    {
        itakeHistoryHandler.init();        
        itakeHistoryHandler.pageContextTitle = document.title;
        History.pushState({}, itakeHistoryHandler.pageContextTitle, itakeHistoryHandler.pageContextUrl);
    }
      // Create the measurement node
    var scrollDiv = document.createElement("div");
    scrollDiv.className = "scrollbar-measure";
    document.body.appendChild(scrollDiv);

// Get the scrollbar width
    scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth;
// Delete the DIV 
    document.body.removeChild(scrollDiv);
    // Prepare
    $('.slim-scroll').each(function() {
        var $this = $(this);
        $this.slimScroll({
            height: $this.data('height') || 100,
            railVisible: true,
            color: '#7e7e7e',
            alwaysVisible:false,
        });
    });    
    alignDiv();
    
    var $introItem = $(".intro_item")
    $(window).scroll(function(event) {

        $introItem.each(function(i, el) {
            var el = $(el);
            if (el.visible(true)) {
                el.addClass("come-in");
            }
            else{
                el.removeClass("come-in");
            }
        });

    });
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
function resetScroll(){
    $.scrollUp.destroy();
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
}
function alignDiv()
{
    $('.page-container').css('min-height',$(window).height()-70); 
    $('.fb-comments span').width('100%');
    commentWidth = $('.fb-comments span').width();
    $('.fb-comments').attr('data-width', commentWidth);
    var marginLeftContainer = ($('body').width() - $('#productContainer').width()) / 2 + $('#productContainer').width() * 0.06;
    //var marginLeftContainer2 = ($('body').width() - $('#userProductBoard').width()) / 2 + $('#userProductBoard').width() * 0.06;
    var marginLeftContainer3 = ($('body').width() - $('#categories-bar').width()) / 2;
    if (marginLeftContainer * 2 != $('body').width())
    {
        // $('#categories-bar').css('margin-left', (marginLeftContainer3) + 'px');
    }

    $('.frmSearch_wrapper').css('width',$('.nav-bar-top').width());
    $('#categories-bar').css('width',$('#menuWidthBase').width());
    $('.selectedCategoryTab').css('left',$('#menuWidthBase').width());
}

function getProductTitle(link){
    var arrStr = link.split('/',20);
    return arrStr[arrStr.length-1].replace('.html','');
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


Number.prototype.formatMoney = function(c, d, t) {
    var n = this,
            c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = d == undefined ? "." : d,
            t = t == undefined ? "," : t,
            s = n < 0 ? "-" : "",
            i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
            j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};


$(document).ready(function() {
    function facebookReady() {
        FB.init({
            appId: '620447237967845',
            status: true,
            cookie: true,
            xfbml: true,
            channelUrl:ABSOLUTE_URL + '/channel.php'
        });
        $(document).trigger("facebook:ready");
    }

    if (window.FB) {
        facebookReady();
    } else {
        window.fbAsyncInit = facebookReady;
    }
});

$.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};
function isotopeAlignCenter(container){
    $(window).smartresize(function(){
    // check if columns has changed
    var currentColumns = Math.floor( (container.width()) / (250+0.02* container.width()) );
    if ( currentColumns !== columns ) {
      // set new column count
      columns = currentColumns;
      // apply width to container manually, then trigger relayout
        var fixWidth = columns * 250+(columns-1)*container.width()*0.03;
      container.width(fixWidth)
        .isotope('reLayout');   
    }
    
  }).smartresize();
}
function masoryCenterAlign()
{
   (function($) {
            $.Isotope.prototype._getCenteredMasonryColumns = function() {
                this.width = this.element.width();

                var parentWidth = this.element.parent().width();

                // i.e. options.masonry && options.masonry.columnWidth
                var colW = this.options.masonry && this.options.masonry.columnWidth ||
                        // or use the size of the first item
                        this.$filteredAtoms.outerWidth(true) ||
                        // if there's no items, use size of container
                        parentWidth;

                var cols = Math.floor(parentWidth / colW);
                cols = Math.max(cols, 1);

                // i.e. this.masonry.cols = ....
                this.masonry.cols = cols;
                // i.e. this.masonry.columnWidth = ...
                this.masonry.columnWidth = colW;
            };

            $.Isotope.prototype._masonryReset = function() {
                // layout-specific props
                this.masonry = {};
                // FIXME shouldn't have to call this again
                this._getCenteredMasonryColumns();
                var i = this.masonry.cols;
                this.masonry.colYs = [];
                while (i--) {
                    this.masonry.colYs.push(0);
                }
            };

            $.Isotope.prototype._masonryResizeChanged = function() {
                var prevColCount = this.masonry.cols;
                // get updated colCount
                this._getCenteredMasonryColumns();            
                return (this.masonry.cols !== prevColCount);
            };

            $.Isotope.prototype._masonryGetContainerSize = function() {
                var unusedCols = 0,
                        i = this.masonry.cols;
                // count unused columns
                while (--i) {
                    if (this.masonry.colYs[i] !== 0) {
                        break;
                    }
                    unusedCols++;
                }            
                return {
                    height: Math.max.apply(Math, this.masonry.colYs),
                    // fit container to columns that have been used;
                    width: (this.masonry.cols - unusedCols) * this.masonry.columnWidth
                };
            };          
        })(jQuery);    
}
function detectmob() { 
   if( navigator.userAgent.match(/Android/i)
       || navigator.userAgent.match(/webOS/i)
       || navigator.userAgent.match(/iPhone/i)
       || navigator.userAgent.match(/iPad/i)
       || navigator.userAgent.match(/iPod/i)
       || navigator.userAgent.match(/BlackBerry/i)
       || navigator.userAgent.match(/Windows Phone/i)
       ){
    return true;
    }
    else {
        return false;
    }
}
(function($) {

    /**
     * Copyright 2012, Digital Fusion
     * Licensed under the MIT license.
     * http://teamdf.com/jquery-plugins/license/
     *
     * @author Sam Sehnert
     * @desc A small plugin that checks whether elements are within
     *     the user visible viewport of a web browser.
     *     only accounts for vertical position, not horizontal.
     */

    $.fn.visible = function(partial) {

        var $t            = $(this),
            $w            = $(window),
            viewTop       = $w.scrollTop(),
            viewBottom    = viewTop + $w.height(),
            _top          = $t.offset().top,
            _bottom       = _top + $t.height(),
            compareTop    = partial === true ? _bottom : _top,
            compareBottom = partial === true ? _top : _bottom;

        return ((compareBottom <= viewBottom) && (compareTop >= viewTop));

    };

})(jQuery);


function elementInScroll(elem)
{
    var docViewTop = $(window).scrollTop();
    var docViewBottom = docViewTop + $(window).height();
 
    var elemTop = $(elem).offset().top;
    var elemBottom = elemTop + $(elem).height();
 
    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}

var _throttleTimer = null;
var _throttleDelay = 100;


function initCheckBottom(callback){
    $(window)
        .off('scroll', ScrollHandler)
        
        .on('scroll', function(e){
            ScrollHandler(e,callback);
        });
}
function ScrollHandler(e,callback) {
    //throttle event:
    clearTimeout(_throttleTimer);
    _throttleTimer = setTimeout(function () {
        console.log('scroll');

        //do work
        if ($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
            callback();
        }

    }, _throttleDelay);
}




function showMessage(message,timeout){
    timeout = timeout || 3000;
    $mainNotification.show('fade');
    $notificationSpan.html(message);
    setTimeout(function () {
        $mainNotification.hide('fade');
    },timeout);
}

function loadImage( elem, img, state )
{
    if (
        (typeof(elem.onerror) === 'function' && state === 'fail') 
        || (elem.width === 0)
        )
         {
           elem.src = img;           
         }         
}

function trackingLink(link){
    _gaq.push(['myTracker._setAccount', 'UA-42949373-1']);
    _gaq.push(['_trackPageview', link]);
}

function detectMobile() {
   if(window.innerWidth <= 800 && window.innerHeight <= 600) {
     return true;
   } else {
     return false;
   }
}