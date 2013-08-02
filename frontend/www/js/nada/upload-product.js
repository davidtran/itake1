var map;
var maker;
var locationData = null;
defaultLat = 21.022983;
defaultLng = 105.831878;
var $addressField;
if (typeof product != "undefined" && product.lat != null && product.lon != null) {
    defaultLat = product.lat;
    defaultLng = product.lon;
}
if (typeof contactInfo != "undefined"&&contactInfo!=null) {
    $('#Product_city').val(contactInfo.city);
    defaultLat = contactInfo.lat != null ? contactInfo.lat : defaultLat;
    defaultLng = contactInfo.lon != null ? contactInfo.lon : defaultLng;
    $('#Product_locationText').val(contactInfo.locationText);
    $('#Product_phone').val(contactInfo.phone);
}
//defaultLat = contactInfo.lat!=null?contactInfo.lat:defaultLat;
//defaultLng = contactInfo.lon!=null?contactInfo.lon:defaultLng;
$(document).ready(function() {
    $('.fileupload').fileupload({
        uploadtype: 'image'
    });
    updatePreview();
});
function updatePreview() {    
    $('div.productImageTitle').html($('#Product_title').val());
    $('div.productImagePrice').html($('#Product_price').val());
    $('div.productDescription').html($('#Product_description').val());
    if($('.fileupload-preview img').attr('src')!=undefined)
    {        
        $('img.productImage').attr('src', $('.fileupload-preview img').attr('src'));
    }
    else
    {
        $('img.productImage').attr('src', $('#productImageHoder').attr('src'));   
    }
    setTimeout(function() {
        updatePreview();
    }, 1000);
}
function selectCategoryAt(idxCat, icontext, catName, styleName) {
    $('#listCategory a.btn.dropdown-toggle').html('<span class="label ' + styleName + '"><i class="' + icontext + '"/>' + catName + '</i></span><span class="caret"></span>');
    $('#Product_category_id').attr('value', idxCat);
}

function getMapSearchQuery(address) {
    //get selected city, vietnam
    var cityId = $('#Product_city').val();
    address = address.trim();
    return address + getCityNameFromId(cityId) + ', Vietnam';
}

function getCityNameFromId(id) {
    if (cityList[id] != undefined) {
        return cityList[id].name;
    }
    return '';
}


function onProductItemClick() {
    $('.productItem .deleteBtn').on('click', function(e) {
        e.preventDefault();
        var $parent = $(this).parent('.productItem');
        var productId = $parent.attr('data-product-id');
        deleteItem(productId, $parent);
    });
}
function deleteItem(productId, productItem) {
    startLoadingBackground(productItem);
    $.ajax({
        url: BASE_URL + '/upload/delete',
        type: 'post',
        success: function(jsons) {
            var json = $.parseJSON(jsons);
            if (json.success) {
                productItem.fadeOut('slow', function() {
                    $('.productBoard').isotope('reLayout');
                });
            }
        },
        complete: function() {
            stopLoadingBackground(productItem);
        }

    })
}

var UploadForm = {
    step1Selector: '#uploadStep1',
    step2Selector: '#uploadStep2',
    finishStep1Selector: '#btnFinishStep1',
    finishStep2Selector: '#btnFinishStep2',
    backToStep1Selector: '#btnBackToStep1',
    startChecking: false,
    fieldList: '#Product_title, #Product_price, #Product_description, #Product_category_id',
    numberField: '#Product_phone',
    imageField: '#productImage',
    init: function() {
        UploadForm.initForm();
        UploadForm.initValidateStep1();
        UploadForm.initFinishStep1();
        UploadForm.initBackToStep1();
        UploadForm.initFinishStep2();
        if (false == isNewRecord) {
            UploadForm.setFinishStep1ButtonState(true);
        }
        UploadForm.initPriceField();
    },    
    initPriceField:function(){
        var priceDisplayValue = $('#Product_priceDisplay').val();
        $('#Product_price').keyup(function(event){
            
            if(event.which >= 37 && event.which <= 40){
                event.preventDefault();
            }

            $(this).val(function(index, value) {
                var number = value.replace(/\D/g, '');
                
                return number.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    
                ;
            });
        });
    },
    initForm: function() {
        $(UploadForm.step1Selector).show();
        $(UploadForm.step2Selector).hide();
        $(UploadForm.finishStep1Selector).addClass('disabled');
    },
    initFinishStep1: function() {
        $(UploadForm.finishStep1Selector).click(function(e) {
            e.preventDefault();
            if (UploadForm.validateStep1Form()) {
                $(UploadForm.step1Selector).slideUp('300', function() {
                    $(UploadForm.step2Selector).slideDown('300', function() {
                        addMap(defaultLat, defaultLng);
                    });
                });
            }
            return false;
        });
    },
    initValidateStep1: function() {
        //check all field in step1
        $(UploadForm.imageField).each(function() {
            $(this).change(function() {
                valid = UploadForm.validateStep1Form();
                UploadForm.setFinishStep1ButtonState(valid);
            });
        });
        $(UploadForm.fieldList).each(function() {
            $(this).keyup(function() {
                valid = UploadForm.validateStep1Form();
                UploadForm.setFinishStep1ButtonState(valid);
            });
        });


        $(UploadForm.numberField).each(function() {
            $(this).keyup(function() {
                valid = UploadForm.validateStep1Form();
                UploadForm.setFinishStep1ButtonState(valid);
            });
        });



    },
    validateStep1Form: function() {
        var valid = true;
        if ($('#productImageHolder').attr('src') != null) {
            $('#productImageHolder').removeClass('error').addClass('valid');
        } else {
            $('#productImageHolder').removeClass('valid').addClass('error');
        }
        

        $(UploadForm.numberField).each(function() {
            UploadForm.startChecking = true;
            if ($(this).val().trim() != '' && $.isNumeric($(this).val()) == false) {
              
                $(this).addClass('error');
                $(this).removeClass('valid');
                valid = false;
            } else {
                $(this).addClass('valid');
                $(this).removeClass('error');
            }
        });
        
        $(UploadForm.fieldList).each(function() {
            UploadForm.startChecking = true;
            fieldValue = $(this).val();
            if (fieldValue.trim() == '') {
                $(this).addClass('error');
                $(this).removeClass('valid');
                valid = false;
            } else {

                $(this).addClass('valid');
                $(this).removeClass('error');
            }
        });
        if(UploadAddress.addressList.find('.radio-address-item:checked').length == 0){
            valid = false;
        }
        var result;
        if (UploadForm.startChecking == false) {
            result = false;
        } else if (valid) {
            result = true;
        }
        
        

        return result;
    },
   
    setFinishStep1ButtonState: function(valid) {
        if (valid) {
            $(UploadForm.finishStep1Selector).removeClass('disabled');
            $('#step1ThongTin').removeClass('current');
            $('#step1ThongTin').addClass('disabled');
            $('#step2DiaDiem').removeClass('disabled');
            $('#step2DiaDiem').addClass('current');
        } else {
            $('#step1ThongTin').removeClass('class', 'disabled');
            $('#step1ThongTin').addClass('class', 'current');
            $(UploadForm.finishStep1Selector).addClass('disabled');
            $('#step2DiaDiem').removeClass('current');
            $('#step2DiaDiem').addClass('disable');
        }
    },
    initBackToStep1: function() {
        $(UploadForm.backToStep1Selector).click(function(e) {
            e.preventDefault();
            $(UploadForm.step2Selector).slideUp('300', function() {
                $(UploadForm.step1Selector).slideDown('300');
            });
            return false;
        })
    },
    initFinishStep2: function() {
        $(UploadForm.finishStep2Selector).click(function(e) {
            $(this).button('loading');
        });
    }
}

$(document).ready(function() {
    UploadForm.init();
})