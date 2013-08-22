
var UploadAddress = {
    addAddressDialog: $("#addAddressDialog"),
    addressForm: $('#addressForm'),
    addressList: $('#addressList'),
    saveAddressButton: $('#btnSaveAddress'),
    map: $('#map'),
    addressField:'#Address_address',    
    init: function() {
        UploadAddress.initShowDialogButton();
        UploadAddress.initDeleteButton();
        UploadAddress.initDialog();
        UploadAddress.initSaveButton();
        UploadAddress.initRadioButton();
        UploadAddress.initAddressField();
    },
    initRadioButton:function(){
        $('.radio-address-item').live('click',function(){
            value = $(this).val();
            $('#Product_address_id').val(value);
        });
        
        if(product != undefined && product.address_id != null){
            UploadAddress.addressList.find('.radio-address-item[value='+product.address_id+']').click();
        }else{
            if($('.radio-address-item').length > 0){
                $('.radio-address-item:eq(0)').click();
            }
        }
        
    },
    
    initShowDialogButton: function() {
        $('.btnAddressDialog').click(function(e) {
            e.preventDefault();
            UploadAddress.showDialog();
            return false;
        })
    },
    initDeleteButton: function() {
        $('.btnDeleteAddress').click(function(e) {
            e.preventDefault();
            var that = $(this);
            addressId = that.attr('data-address-id');
            productId = product.id;
            UploadAddress.deleteAddress(addressId,productId, function(data) {
                if(data.success){
                    that.parents('.addressItem').fadeOut();
                }else{
                    bootbox.alert(data.msg);
                }
            });
            return false;
        });
    },
    initSaveButton: function() {
        UploadAddress.saveAddressButton.click(function(e) {
            e.preventDefault();
            UploadAddress.saveAddress(function(msg) {
                UploadAddress.addressList.prepend(msg.html);
                UploadAddress.addressList.find('.radio-address-item:eq(0)').click();
                UploadAddress.addAddressDialog.modal('hide');
                
            },function(msg){
                bootbox.alert(msg);
            });
            return false;
        });
    },
    saveAddress: function(callback, errorCallback) {
        callback = callback || function() {
        };
        errorCallback = errorCallback || function() {
        };
        $.ajax({
            url: BASE_URL + '/upload/addAddress',
            type: 'post',
            data: UploadAddress.addressForm.serializeObject(),
            success: function(json) {
                var data = $.parseJSON(json);
                if (data.success) {
                    callback(data.msg);
                } else {
                    errorCallback(data.msg);
                }
            }
        })
    },
    deleteAddress: function(addressId,productId, callback) {
        callback = callback || function() {
        };
        $.ajax({
            url: BASE_URL + '/upload/deleteAddress',
            data: {
                addressId: addressId,
                productId:productId
            },
            type: 'post',
            success: function(jsons) {
                var json = $.parseJSON(jsons);
                
                callback(json);
                
            }
        });
    },
    initDialog: function() {
        $('#Address_city').change(function(e) {
            UploadAddress.onCityChange($(this).val());
        });
        if(cityList!=null)
        {       
            var firstCityIndex = null;
             for (var prop in cityList)
             {
                if (cityList.propertyIsEnumerable(prop))
                {
                   firstCityIndex = prop;
                   return;
               }
            }
               defaultLat = cityList[firstCityIndex].latitude;
               defaultLng = cityList[firstCityIndex].longitude;
        }
        UploadAddress.addAddressDialog.on('shown', function() {
            UploadAddress.map = MapUtils.addMap(UploadAddress.map,defaultLat,defaultLng);
        });
    },
    onCityChange: function(value) {
        $.ajax({
            url: BASE_URL + '/upload/getGeoData',
            data: {
                cityId: value
            },
            type: 'get',
            success: function(json) {
                console.log(json);
                data = $.parseJSON(json);
                if (data.success) {
                    UploadAddress.setFormLatLon(data.msg.latitude, data.msg.longitude);
                    UploadAddress.map = MapUtils.addMap(UploadAddress.map,data.msg.latitude, data.msg.longitude);
                    
                    MapUtils.placeMarker(UploadAddress.map,data.msg.latitude, data.msg.longitude,function(address){                 
                    });
                    locationData = data.msg;
                }
            }
        });
    },
    setFormLatLon:function(lat,lon){
        $('#Address_lat').val(lat);
        $('#Address_lon').val(lon);
    },
    initAddressField: function() {
        $(UploadAddress.addressField).keydown(function(e){
            console.log(e.keycode);
            if (e.keyCode == 13) {
                e.preventDefault();
                UploadAddress.seachMapByAddress($(UploadAddress.addressField).val(), $('#Address_city option:selected').text());
                return false;
            }
        });
        $('#btnSearchLocation').click(function(e){
            e.preventDefault();
            UploadAddress.seachMapByAddress($(UploadAddress.addressField).val(), $('#Address_city option:selected').text());
            return false;
        });
    },
    seachMapByAddress:function(address,cityName){
        var address = address + ',' + cityName;
        MapUtils.searchMapByAddress(
                address,
                function(lat,lon){
                    UploadAddress.setFormLatLon(lat,lon);
                    UploadAddress.map = MapUtils.addMap(UploadAddress.map,lat,lon);                  
                }
            );
    },
            
    showDialog: function() {
        UploadAddress.addAddressDialog.modal('show');
    }
    
};

$(document).ready(function() {
    UploadAddress.init();
});


var MapUtils = {
    searchMapByAddress: function(address,callback) {
        callback = callback || function(){};
        GMaps.geocode({
            address: getMapSearchQuery(address),
            callback: function(results, status) {
                if (status == 'OK') {
                    var latlng = results[0].geometry.location;
                    callback(latlng.lat(), latlng.lng());
                } else {
                    alert('Không tìm thấy kết quả cho địa chỉ bạn nhập, vui lòng nhập lại.');
                }
            }
        });
    },
    addMap: function(selector,lat, lng,callback) {
        callback = callback || function(){};
        
        selector = new GMaps({
            div: '#map',
            lat: lat,
            lng: lng,
            width: 500,
            height: 400,
            zoom: 15,
            click: function(e) {
               
                MapUtils.placeMarker(selector,e.latLng.lat(), e.latLng.lng());
            }
        });
        selector.addControl({
            position: 'top_right',
            text: 'Nơi bán hàng',
            style: {
                margin: '5px',
                padding: '1px 6px',
                border: 'solid 1px #717B87',
                background: '#fff'
            },
            events: {
                click: function() {
                    GMaps.geolocate({
                        success: function(position) {
                            selector.setCenter(position.coords.latitude, position.coords.longitude);
                        },
                        error: function(error) {
                            alert('Không thể đặt vị trí: ' + error.message);
                        },
                        not_supported: function() {
                            alert("Trình duyệt của bạn không cho phép sử dụng bản đồ");
                        }
                    });
                }
            }
        });

        
        selector.addMarker({
            lat: lat,
            lng: lng,
            icon: 'http://i.imgur.com/jfx5t.png',
        });
        callback();
        return selector;
    },
    placeMarker: function(selector,lat, lng,callback) {
        callback = callback || function(){};
        selector.removeMarkers();
        $('#Product_lat').val(lat);
        $('#Product_lon').val(lng);


        GMaps.geocode({
            lat: lat,
            lng: lng,
            callback: function(results, status) {
                if (status == 'OK') {
                    var formatAddress = results[0].formatted_address;
                    console.log(results[0]);
                    callback(results[0].formatted_address);                    
                    var latlng = results[0].geometry.location;
                    selector.setCenter(latlng.lat(), latlng.lng());
                    selector.addMarker({
                        lat: latlng.lat(),
                        lng: latlng.lng()
                    });
                }
            }
        });
    }
};